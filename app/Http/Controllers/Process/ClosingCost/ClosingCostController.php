<?php

namespace Bame\Http\Controllers\Process\ClosingCost;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\Process\ClosingCost\Param;
use Bame\Models\Process\ClosingCost\ClosingCost;
use Bame\Http\Requests\Process\ClosingCost\ClosingCostRequest;
use Bame\Models\Notification\Notification;

class ClosingCostController extends Controller
{
    public function index(Request $request)
    {
        $params = Param::all();

        $credits_type = $params->where('type', 'TIPCRE');
        $warranties_type = $params->where('type', 'TIPGAR');

        $closing_costs = ClosingCost::lastestFirst();

        if ($request->term) {
            $term = cap_str($request->term);

            $closing_costs = $closing_costs->orWhere('ranks', 'like', '%' . $term . '%')
                        ->orWhere('rate', 'like', '%' . $term . '%');
        }

        if ($request->credit_type) {
            $closing_costs->where('credtyp_id', $request->credit_type);
        }

        if ($request->warranty_type) {
            $closing_costs->where('credtyp_id', $request->warrant_type);
        }

        if ($request->date_from) {
            $closing_costs->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $closing_costs->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $closing_costs = $closing_costs->paginate();

        return view('process.closing_cost.index', [
            'credits_type' => $credits_type,
            'warranties_type' => $warranties_type,
            'closing_costs' => $closing_costs,
        ]);
    }

    public function create()
    {
        $params = Param::all();

        $credits_type = $params->where('type', 'TIPCRE');
        $warranties_type = $params->where('type', 'TIPGAR');

        return view('process.closing_cost.create', [
            'credits_type' => $credits_type,
            'warranties_type' => $warranties_type,
        ]);
    }

    public function store(RequestClosingCost $request)
    {
        dd($request->all());
        $process_request = new ClosingCost;

        $params = Param::whereIn('id', [$request->request_type, $request->process, $request->subprocess])->get();

        $request_type = $params->where('id', $request->request_type)->where('type', 'TIPSOL')->first();
        $process = $params->where('id', $request->process)->where('type', 'PRO')->first();

        if (is_null($request_type) || is_null($process)) {
            return back()->withInput()->withError('Los parámetros seleccionados no son correctos.');
        }

        $process_request->id = uniqid(true);
        $process_request->reqtype = $request_type->note;
        $process_request->reqstatus = 'Pendiente';
        $process_request->process = "{$process->name} v( {$process->version} )";
        $process_request->note = $request->description;
        $process_request->causeanaly = $request->cause_analysis;
        $process_request->peoinvolve = $request->people_involved;

        $process_request->created_by = session()->get('user');
        $process_request->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $process_request->reqnumber = get_next_request_number();
        $process_request->save();

        $process_request->createStatus('Creada', 'Solicitud creada');

        do_log('Creó la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' )');

        return redirect(route('process.request.show', ['request' => $process_request->id]))->with('success', 'La solicitud ha sido creada correctamente.');

    }

    public function show($request)
    {
        $process_request = ClosingCost::find($request);

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

        $process_request = ClosingCost::find($process_request);

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

            $approval->id = uniqid(true);
            $approval->userapprov = $user;
            $approval->approved = '';
            $approval->approvdate = null;

            $approval->created_by = session()->get('user');
            $approval->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

            $users->push($approval);

            Notification::notify('Solicitud de Procesos', "Usted ha sido colocado como usuario para aprobar la solicitud {$process_request->reqnumber}.", route('process.request.show', ['request' => $process_request->id]), $user);
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

        $process_request = ClosingCost::find($process_request);

        if (!$process_request) {
            return redirect(route('process.request.index'));
        }

        $approval = $process_request->approvals()->where('userapprov', session()->get('user'))->update([
            'approved' => $request->a == '1',
            'approvdate' => new \DateTime,
            'username' => session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName(),
            'title' => session()->get('user_info')->getTitle(),
            'comment' => $request->comment,
        ]);

        $status = $process_request->getStatus();

        if ($status == '1') {
            $process_request->reqstatus = 'Aprobada';
        }

        if ($status == '0') {
            $process_request->reqstatus = 'Rechazada';
        }

        if ($status == '1' || $status == '0') {
            $process_request->save();
            $process_request->createStatus($process_request->reqstatus, 'Solicitud ' . $process_request->reqstatus);
        }

        do_log($request->a == '1' ? 'Aprobó':'Rechazó' . ' la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' )');

        return redirect(route('process.request.show', ['request' => $process_request->id]))->with('success', 'Su aprobación ha sido procesada correctamente.');
    }

    public function deleteuser(Request $request, $process_request)
    {
        if (can_not_do('process_request_admin')) {
            return redirect(route('process.request.show', ['request' => $process_request]))->with('error', 'Usted no tiene permiso para ejecutar esta acción.');
        }

        $process_request = ClosingCost::find($process_request);

        if (!$process_request) {
            return redirect(route('process.request.index'));
        }

        $approval = $process_request->approvals()->where('userapprov', $request->u)->delete();

        Notification::notify('Solicitud de Procesos', "Usted ha sido removido de los usuarios que pueden aprobar la solicitud {$process_request->reqnumber}.", route('process.request.show', ['request' => $process_request->id]), $request->u);

        do_log('Elimino el usuario de Aprobación a la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' usuario:' . $request->u . ' )');

        return redirect(route('process.request.show', ['request' => $process_request->id]))->with('success', 'El usuario ha sido eliminado correctamente.');
    }

    public function addstatus(Request $request, $process_request)
    {
        $this->validate($request, [
            'status' => 'required',
            'comment' => 'required|max:1000',
        ]);

        $process_request = ClosingCost::find($process_request);
        $status = Param::where('type', 'EST')->find($request->status);

        if (!$process_request || !$status) {
            return redirect(route('process.request.index'));
        }

        $process_request->createStatus($status->note, $request->comment);

        $process_request->reqstatus = $status->note;

        $process_request->save();

        Notification::notify('Solicitud de Procesos', "La solicitud {$process_request->reqnumber} ha cambiado al estatus {$status->note}", route('process.request.show', ['request' => $process_request->id]), $process_request->created_by);

        do_log('Agregó un Estatus a la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' estatus:' . $status->note . ' )');

        return redirect(route('process.request.show', ['request' => $process_request->id]))->with('success', 'El estatus sido agregado correctamente.');

    }

    public function addattach(Request $request, $process_request)
    {
        {
            $process_request = ClosingCost::find($process_request);

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
        $process_request = ClosingCost::find($process_request);

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
        $process_request = ClosingCost::find($process_request);

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
