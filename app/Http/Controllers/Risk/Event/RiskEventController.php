<?php

namespace Bame\Http\Controllers\Risk\Event;

use Illuminate\Http\Request;
use Bame\Models\Risk\Event\Param;
use Bame\Http\Controllers\Controller;
use Bame\Models\Risk\Event\RiskEvent;
use Bame\Models\Notification\Notification;
use Bame\Http\Requests\Risk\Event\RiskEventRequest;

class RiskEventController extends Controller
{
    public function index(Request $request)
    {
        // $risk_events = RiskEvent::lastestFirst();

        // if ($request->term) {
        //     $term = cap_str($request->term);
        // }

        // if ($request->request_type) {
        //     $risk_events->where('reqtype', $request->request_type);
        // }

        // if ($request->process) {
        //     $risk_events->where('process', $request->process);
        // }

        // if ($request->date_from) {
        //     $risk_events->where('created_at', '>=', $request->date_from . ' 00:00:00');
        // }

        // if ($request->date_to) {
        //     $risk_events->where('created_at', '<=', $request->date_to . ' 23:59:59');
        // }

        // $risk_events = $risk_events->paginate();

        $params = Param::get();

        return view('risk.event.index', [
            // 'risk_events' => $risk_events,
            'params' => $params,
        ]);
    }

    public function create()
    {
        $params = Param::activeOnly()->get();

        return view('risk.event.create', [
            'params' => $params,
        ]);
    }

    public function store(RiskEventRequest $request)
    {
        $risk_event = new RiskEvent;

        $risk_event->id = uniqid(true);

        $risk_event->busineline = $request->business_line;
        $risk_event->event_type = $request->event_type;
        $risk_event->curre_type = $request->currency_type;
        $risk_event->bran_offic = $request->branch_office;
        $risk_event->area_depar = $request->area_department;
        $risk_event->dist_chann = $request->distribution_channel;
        $risk_event->dist_chann = $request->distribution_channel;
        $risk_event->process = $request->process;
        $risk_event->subprocess = $request->subprocess;

        $risk_event->descriptio = $request->description;
        $risk_event->consequenc = $request->consequence;
        $risk_event->assoc_cont = $request->associated_control;

        $risk_event->created_by = session()->get('user');
        $risk_event->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $risk_event->save();

        do_log('Creó el Evento de Riesgo Operacional ( número:' . $risk_event->id . ' )');

        return redirect()->route('risk.event.show', ['request' => $risk_event->id])->with('success', 'La solicitud ha sido creada correctamente.');

    }

    public function show($request)
    {
        $risk_event = RiskEvent::find($request);

        if (!$risk_event) {
            return redirect()->route('risk.event.index');
        }

        do_log('Consultó el Evento de Riesgo Operacional ( número:' . $risk_event->id . ' )');

        return view('risk.event.show', [
            'risk_event' => $risk_event,
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

        $process_request = ProcessRequest::find($process_request);

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

        $process_request = ProcessRequest::find($process_request);

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

        $process_request = ProcessRequest::find($process_request);
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
