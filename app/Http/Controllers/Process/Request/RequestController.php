<?php

namespace Bame\Http\Controllers\Process\Request;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\Process\Request\Param;
use Bame\Models\Process\Request\ProcessRequest;
use Bame\Models\Process\Request\Approval;
use Bame\Models\Process\Request\Status;
use Bame\Models\Process\Request\Attach;
use Bame\Http\Requests\Process\Request\RequestProcessRequest;

class RequestController extends Controller
{
    public function index()
    {
        $param = Param::all();

        $request_types = $param->where('type', 'TIPSOL');
        $request_statuses = $param->where('type', 'EST');
        $request_processes = $param->where('type', 'PRO');

        $process_requests = ProcessRequest::lastestFirst()->paginate();

        return view('process.request.index', [
            'request_types' => $request_types,
            'request_statuses' => $request_statuses,
            'request_processes' => $request_processes,
            'process_requests' => $process_requests,
        ]);
    }

    public function create()
    {
        $params = Param::activeOnly()->get();

        $request_types = $params->where('type', 'TIPSOL');
        $processes = $params->where('type', 'PRO');

        return view('process.request.create', [
            'request_types' => $request_types,
            'processes' => $processes,
        ]);
    }

    public function store(RequestProcessRequest $request)
    {
        $process_request = new ProcessRequest;

        $params = Param::whereIn('id', [$request->request_type, $request->process, $request->subprocess])->get();

        $request_type = $params->where('id', $request->request_type)->where('type', 'TIPSOL')->first();
        $process = $params->where('id', $request->process)->where('type', 'PRO')->first();
        $subprocess = $params->where('id', $request->subprocess)->where('type', 'PRO')->where('id_parent', $process->id)->first();

        if (is_null($request_type) || is_null($process) || is_null($subprocess)) {
            return back()->withInput()->withError('Los parámetros seleccionados no son correctos.');
        }

        $process_request->id = uniqid(true);
        $process_request->reqtype = $request_type->note;
        $process_request->process = "{$process->name} v( {$process->version} )";
        $process_request->subprocess = "{$subprocess->name} v( {$subprocess->version} )";
        $process_request->note = $request->description;
        $process_request->causeanaly = $request->cause_analysis;
        $process_request->peoinvolve = $request->people_involved;
        $process_request->deliverabl = $request->deliverable;
        $process_request->observatio = $request->observations;
        $process_request->requested = true;

        $process_request->created_by = session()->get('user');
        $process_request->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $process_request->reqnumber = get_next_request_number();
        $process_request->save();

        do_log('Creó la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' )');

        return redirect(route('process.request.show', ['request' => $process_request->id]))->with('success', 'La solicitud ha sido creada correctamente.');

    }

    public function show($request)
    {
        $process_request = ProcessRequest::find($request);

        $status = Param::where('type', 'EST')->activeOnly()->get();

        if (!$process_request) {
            return redirect(route('process.request.index'));
        }

        do_log('Consultó la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' )');

        return view('process.request.show', [
            'process_request' => $process_request,
            'is_approved' => $process_request->isApproved(),
            'status' => $status,
        ]);
    }

    public function addusers(Request $request, $process_request)
    {
        $this->validate($request, [
            'users' => 'required'
        ]);

        $process_request = ProcessRequest::find($process_request);

        if (!$process_request) {
            return redirect(route('process.request.index'));
        }

        $approvals = $process_request->approvals;

        $arr_users = collect(explode(' ', trim($request->users)));

        $users = collect();

        foreach ($arr_users->unique() as $index => $user) {
            if ($approvals->contains('userapprov', $user)) {
                continue;
            }

            $approval = new Approval;

            $approval->id = uniqid(true) . $index;
            $approval->userapprov = $user;
            $approval->approved = '';
            $approval->approvdate = null;

            $approval->created_by = session()->get('user');
            $approval->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

            $users->push($approval);
        }

        $process_request->approvals()->saveMany($users);

        do_log('Agregó Usuarios de Aprobación a la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' usuarios:' . str_replace(' ', ',',  trim($request->users)).' )');

        return redirect(route('process.request.show', ['request' => $process_request->id]))->with('success', 'Los usuarios han sido agregados correctamente.');

    }

    public function approval(Request $request, $process_request)
    {
        if (can_not_do('process_request_approval')) {
            return redirect(route('process.request.show', ['request' => $process_request]))->with('error', 'Usted no tiene permiso para ejecutar esta acción.');
        }

        $process_request = ProcessRequest::find($process_request);

        if (!$process_request) {
            return redirect(route('process.request.index'));
        }

        $approval = $process_request->approvals()->where('userapprov', session()->get('user'))->update([
            'approved' => $request->a == '1',
            'approvdate' => new \DateTime,
            'username' => session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName(),
        ]);

        do_log($request->a == '1' ? 'Aprobó':'Rechazó' . ' la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' )');

        return redirect(route('process.request.show', ['request' => $process_request->id]))->with('success', 'Su aprobación ha sido procesada correctamente.');
    }

    public function deleteuser(Request $request, $process_request)
    {
        if (can_not_do('process_request_admin')) {
            return redirect(route('process.request.show', ['request' => $process_request]))->with('error', 'Usted no tiene permiso para ejecutar esta acción.');
        }

        $process_request = ProcessRequest::find($process_request);

        if (!$process_request) {
            return redirect(route('process.request.index'));
        }

        $approval = $process_request->approvals()->where('userapprov', $request->u)->delete();

        do_log('Elimino el usuario de Aprobación a la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' usuario:' . $request->u . ' )');

        return redirect(route('process.request.show', ['request' => $process_request->id]))->with('success', 'El usuario ha sido eliminado correctamente.');
    }

    public function addstatus(Request $request, $process_request)
    {
        $this->validate($request, [
            'status' => 'required',
            'comment' => 'required|max:1000',
        ]);

        $process_request = ProcessRequest::find($process_request);
        $status = Param::where('type', 'EST')->find($request->status);

        if (!$process_request || !$status) {
            return redirect(route('process.request.index'));
        }

        $process_request_status = new Status;

        $process_request_status->id = uniqid(true);
        $process_request_status->status = $status->note;
        $process_request_status->comment = $request->comment;

        $process_request_status->created_by = session()->get('user');
        $process_request_status->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $process_request->status()->save($process_request_status);

        if ($process_request->requested) {
            $process_request->requested = false;
            $process_request->save();
        }

        do_log('Agregó un Estatus a la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' estatus:' . $status->note . ' )');

        return redirect(route('process.request.show', ['request' => $process_request->id]))->with('success', 'El estatus sido agregado correctamente.');

    }

    public function addattach(Request $request, $process_request)
    {
        {
            $process_request = ProcessRequest::find($process_request);

            if (!$process_request) {
                return redirect(route('process.request.index'));
            }

            if ($request->hasFile('files')) {
                $files = collect($request->file('files'));

                $path = storage_path('app\\process_request\\attaches\\' . $process_request->id . '\\');

                $files->each(function ($file, $index) use ($path, $process_request) {
                    $file_name_destination = str_replace(' ', '_', $file->getClientOriginalName());

                    $file_name_destination = remove_accents($file_name_destination);

                    $file->move($path, $file_name_destination);

                    $attach = new Attach;

                    $attach->id = uniqid(true);
                    $attach->file = $file_name_destination;

                    $attach->created_by = session()->get('user');
                    $attach->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

                    $process_request->attaches()->save($attach);
                });

                do_log('Adjuntó archivos a la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' )');
            }

            return back()->with('success', 'Los archivos han sido cargados correctamente.');
        }
    }

    public function downloadattach(Request $request, $process_request)
    {
        $process_request = ProcessRequest::find($process_request);

        if (!$process_request) {
            return redirect(route('process.request.index'));
        }

        $attach = $process_request->attaches()->where('id', $request->attach)->first();

        if (!$attach) {
            return back()->with('warning', 'Este adjunto no existe!');
        }

        $path = storage_path('app\\process_request\\attaches\\' . $process_request->id . '\\' . $attach->file);

        do_log('Descargó archivo de la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' archivo:' . $attach->file . ' )');

        return response()->download($path);
    }

    public function deleteattach(Request $request, $process_request)
    {
        $process_request = ProcessRequest::find($process_request);

        if (!$process_request) {
            return redirect(route('process.request.index'));
        }

        $attach = $process_request->attaches()->where('id', $request->attach)->first();

        if (!$attach) {
            return back()->with('warning', 'Este adjunto no existe!');
        }

        do_log('Eliminó archivo de la Reclamación ( número:' . strip_tags($process_request->reqnumber) . ' archivo:' . $attach->file . ' )');

        $attach->delete_attach();
        $attach->delete();

        return back()->with('success', 'El adjunto ha sido eliminado correctamente!');
    }
}
