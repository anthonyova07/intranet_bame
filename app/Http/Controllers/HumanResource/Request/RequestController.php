<?php

namespace Bame\Http\Controllers\HumanResource\Request;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\HumanResource\Request\Param;
use Bame\Models\HumanResource\Request\HumanResourceRequest;
use Bame\Models\HumanResource\Request\Approval;
use Bame\Models\HumanResource\Request\Status;
use Bame\Http\Requests\HumanResource\Request\RequestHumanResourceRequest;
use Bame\Models\Notification\Notification;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $params = Param::all();

        $human_resource_requests = HumanResourceRequest::lastestFirst();

        if ($request->term) {
            $term = cap_str($request->term);

            $human_resource_requests = $human_resource_requests->orWhere('reqnumber', 'like', '%' . $term . '%')
                        ->orWhere('reqtype', 'like', '%' . $term . '%')
                        ->orWhere('note', 'like', '%' . $term . '%');
        }

        if ($request->date_from) {
            $human_resource_requests->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $human_resource_requests->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        if (!can_not_do('human_resource_request_approval')) {
            //
        }

        return view('human_resources.request.index', [
            'human_resource_requests' => $human_resource_requests->paginate(),
            'params' => $params,
        ]);
    }

    public function create(Request $request)
    {
        $params = Param::where('is_active', '1')->get();

        if ($request->type) {
            if (!array_key_exists($request->type, rh_req_types()->toArray())) {
                return redirect(route('human_resources.request.create'))->with('warning', 'El tipo de solicitud seleccionado no existe.');
            }
        }

        return view('human_resources.request.create', [
            'type' => $request->type,
            'request_type_exists' => array_key_exists($request->type, rh_req_types()->toArray()),
            'params' => $params,
        ]);
    }

    public function store(RequestHumanResourceRequest $request)
    {
        dd($request->all());
        $human_resource_request = new HumanResourceRequest;

        $param = Param::find($request->request_type);

        $request_type = $params->where('id', $request->request_type)->where('type', 'TIPSOL')->first();
        $human_resource = $params->where('id', $request->human_resource)->where('type', 'PRO')->first();

        if (is_null($request_type) || is_null($human_resource)) {
            return back()->withInput()->withError('Los parámetros seleccionados no son correctos.');
        }

        $human_resource_request->id = uniqid(true);
        $human_resource_request->reqtype = $request_type->note;
        $human_resource_request->reqstatus = 'Pendiente';
        $human_resource_request->human_resource = "{$human_resource->name} v( {$human_resource->version} )";
        $human_resource_request->note = $request->description;
        $human_resource_request->causeanaly = $request->cause_analysis;
        $human_resource_request->peoinvolve = $request->people_involved;

        $human_resource_request->created_by = session()->get('user');
        $human_resource_request->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $human_resource_request->reqnumber = get_next_request_number();
        $human_resource_request->save();

        $human_resource_request->createStatus('Creada', 'Solicitud creada');

        do_log('Creó la Solicitud de Procesos ( número:' . strip_tags($human_resource_request->reqnumber) . ' )');

        return redirect(route('human_resources.request.show', ['request' => $human_resource_request->id]))->with('success', 'La solicitud ha sido creada correctamente.');

    }

    public function show($request)
    {
        $human_resource_request = HumanResourceRequest::find($request);

        $status = Param::where('type', 'EST')->activeOnly()->get();

        if (!$human_resource_request) {
            return redirect(route('human_resources.request.index'));
        }

        do_log('Consultó la Solicitud de Procesos ( número:' . strip_tags($human_resource_request->reqnumber) . ' )');

        return view('human_resources.request.show', [
            'human_resource_request' => $human_resource_request,
            'is_approved' => $human_resource_request->isApproved(),
            'status' => $status,
        ]);
    }

    public function addusers(Request $request, $human_resource_request)
    {
        $this->validate($request, [
            'users' => 'required'
        ]);

        $human_resource_request = HumanResourceRequest::find($human_resource_request);

        if (!$human_resource_request) {
            return redirect(route('human_resources.request.index'));
        }

        $approvals = $human_resource_request->approvals;

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

            Notification::notify('Solicitud de Procesos', "Usted ha sido colocado como usuario para aprobar la solicitud {$human_resource_request->reqnumber}.", route('human_resources.request.show', ['request' => $human_resource_request->id]), $user);
        }

        $human_resource_request->approvals()->saveMany($users);

        do_log('Agregó Usuarios de Aprobación a la Solicitud de Procesos ( número:' . strip_tags($human_resource_request->reqnumber) . ' usuarios:' . str_replace(' ', ',',  trim($request->users)).' )');

        return redirect(route('human_resources.request.show', ['request' => $human_resource_request->id]))->with('success', 'Los usuarios han sido agregados correctamente.');

    }

    public function approval(Request $request, $human_resource_request)
    {
        if (can_not_do('human_resource_request_approval')) {
            return redirect(route('human_resources.request.show', ['request' => $human_resource_request]))->with('error', 'Usted no tiene permiso para ejecutar esta acción.');
        }

        $human_resource_request = HumanResourceRequest::find($human_resource_request);

        if (!$human_resource_request) {
            return redirect(route('human_resources.request.index'));
        }

        $approval = $human_resource_request->approvals()->where('userapprov', session()->get('user'))->update([
            'approved' => $request->a == '1',
            'approvdate' => new \DateTime,
            'username' => session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName(),
            'title' => session()->get('user_info')->getTitle(),
            'comment' => $request->comment,
        ]);

        $status = $human_resource_request->getStatus();

        if ($status == '1') {
            $human_resource_request->reqstatus = 'Aprobada';
        }

        if ($status == '0') {
            $human_resource_request->reqstatus = 'Rechazada';
        }

        if ($status == '1' || $status == '0') {
            $human_resource_request->save();
            $human_resource_request->createStatus($human_resource_request->reqstatus, 'Solicitud ' . $human_resource_request->reqstatus);
        }

        do_log($request->a == '1' ? 'Aprobó':'Rechazó' . ' la Solicitud de Procesos ( número:' . strip_tags($human_resource_request->reqnumber) . ' )');

        return redirect(route('human_resources.request.show', ['request' => $human_resource_request->id]))->with('success', 'Su aprobación ha sido procesada correctamente.');
    }

    public function deleteuser(Request $request, $human_resource_request)
    {
        if (can_not_do('human_resource_request_admin')) {
            return redirect(route('human_resources.request.show', ['request' => $human_resource_request]))->with('error', 'Usted no tiene permiso para ejecutar esta acción.');
        }

        $human_resource_request = HumanResourceRequest::find($human_resource_request);

        if (!$human_resource_request) {
            return redirect(route('human_resources.request.index'));
        }

        $approval = $human_resource_request->approvals()->where('userapprov', $request->u)->delete();

        Notification::notify('Solicitud de Procesos', "Usted ha sido removido de los usuarios que pueden aprobar la solicitud {$human_resource_request->reqnumber}.", route('human_resources.request.show', ['request' => $human_resource_request->id]), $request->u);

        do_log('Elimino el usuario de Aprobación a la Solicitud de Procesos ( número:' . strip_tags($human_resource_request->reqnumber) . ' usuario:' . $request->u . ' )');

        return redirect(route('human_resources.request.show', ['request' => $human_resource_request->id]))->with('success', 'El usuario ha sido eliminado correctamente.');
    }

    public function addstatus(Request $request, $human_resource_request)
    {
        $this->validate($request, [
            'status' => 'required',
            'comment' => 'required|max:1000',
        ]);

        $human_resource_request = HumanResourceRequest::find($human_resource_request);
        $status = Param::where('type', 'EST')->find($request->status);

        if (!$human_resource_request || !$status) {
            return redirect(route('human_resources.request.index'));
        }

        $human_resource_request->createStatus($status->note, $request->comment);

        $human_resource_request->reqstatus = $status->note;

        $human_resource_request->save();

        Notification::notify('Solicitud de Procesos', "La solicitud {$human_resource_request->reqnumber} ha cambiado al estatus {$status->note}", route('human_resources.request.show', ['request' => $human_resource_request->id]), $human_resource_request->created_by);

        do_log('Agregó un Estatus a la Solicitud de Procesos ( número:' . strip_tags($human_resource_request->reqnumber) . ' estatus:' . $status->note . ' )');

        return redirect(route('human_resources.request.show', ['request' => $human_resource_request->id]))->with('success', 'El estatus sido agregado correctamente.');

    }

    public function addattach(Request $request, $human_resource_request)
    {
        {
            $human_resource_request = HumanResourceRequest::find($human_resource_request);

            if (!$human_resource_request) {
                return redirect(route('human_resources.request.index'));
            }

            if ($request->hasFile('files')) {
                $files = collect($request->file('files'));

                $path = storage_path('app\\human_resource_request\\attaches\\' . $human_resource_request->id . '\\');

                $files->each(function ($file, $index) use ($path, $human_resource_request) {
                    $file_name_destination = str_replace(' ', '_', $file->getClientOriginalName());

                    $file_name_destination = remove_accents($file_name_destination);

                    $file->move($path, $file_name_destination);

                    $attach = new Attach;

                    $attach->id = uniqid(true);
                    $attach->file = $file_name_destination;

                    $attach->created_by = session()->get('user');
                    $attach->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

                    $human_resource_request->attaches()->save($attach);
                });

                do_log('Adjuntó archivos a la Solicitud de Procesos ( número:' . strip_tags($human_resource_request->reqnumber) . ' )');
            }

            return back()->with('success', 'Los archivos han sido cargados correctamente.');
        }
    }

    public function downloadattach(Request $request, $human_resource_request)
    {
        $human_resource_request = HumanResourceRequest::find($human_resource_request);

        if (!$human_resource_request) {
            return redirect(route('human_resources.request.index'));
        }

        $attach = $human_resource_request->attaches()->where('id', $request->attach)->first();

        if (!$attach) {
            return back()->with('warning', 'Este adjunto no existe!');
        }

        $path = storage_path('app\\human_resource_request\\attaches\\' . $human_resource_request->id . '\\' . $attach->file);

        do_log('Descargó archivo de la Solicitud de Procesos ( número:' . strip_tags($human_resource_request->reqnumber) . ' archivo:' . $attach->file . ' )');

        return response()->download($path);
    }

    public function deleteattach(Request $request, $human_resource_request)
    {
        $human_resource_request = HumanResourceRequest::find($human_resource_request);

        if (!$human_resource_request) {
            return redirect(route('human_resources.request.index'));
        }

        $attach = $human_resource_request->attaches()->where('id', $request->attach)->first();

        if (!$attach) {
            return back()->with('warning', 'Este adjunto no existe!');
        }

        do_log('Eliminó archivo de la Reclamación ( número:' . strip_tags($human_resource_request->reqnumber) . ' archivo:' . $attach->file . ' )');

        $attach->delete_attach();
        $attach->delete();

        return back()->with('success', 'El adjunto ha sido eliminado correctamente!');
    }
}
