<?php

namespace Bame\Http\Controllers\HumanResource\Request;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Request\Param;
use Bame\Models\HumanResource\Request\HumanResourceRequest;

class ApproveController extends Controller
{
    public function approve(Request $request, $request_id, $to_approve, $type)
    {
        $human_resource_request = HumanResourceRequest::find($request_id);

        if (!$human_resource_request || !in_array($type, ['sup', 'rh'])) {
            return redirect(route('human_resources.request.index'))->with('warning', 'La solicitud no existe!');
        }

        $user_info = session()->get('user_info');

        if ($type == 'sup') {
            if ($human_resource_request->colsupuser != session()->get('user')) {
                return back()->with('warning', 'Usted no esta autorizado a aprobar esta solicitud!');
            }

            if ($human_resource_request->approvesup != 'p') {
                return back()->with('info', 'La solicitud ya ha sido trabajada por el supervisor');
            } else {
                $human_resource_request->approvesup = $to_approve;
                $human_resource_request->reqstatus = $human_resource_request->approvesup == 'a' ? 'Pendiente por RRHH' : 'Rechazado por Supervisor';
                $human_resource_request->save();

                Notification::notify('Solicitud de RH', 'Tu solicitud #' . $human_resource_request->reqnumber . ' de RH ha sido ' . ((bool) $to_approve ? 'aprobada' : 'rechazada') . ' por tu supervisor.', route('human_resources.request.show', ['request' => $human_resource_request->id]), $human_resource_request->created_by);

                do_log(((bool) $to_approve ? 'Aprob' : 'Rechaz') . 'ó como Supervisor la Solicitud de Recursos Humanos ( número:' . strip_tags($human_resource_request->reqnumber) . ' )');

                if ($human_resource_request->approvesup) {
                    Notification::notifyUsersByPermission('human_resource_request', 'Solicitud de RH', 'Nueva ' . rh_req_types($human_resource_request->reqtype) . ' creada (#' . $human_resource_request->reqnumber . ') pendiente.', route('human_resources.request.show', ['id' => $human_resource_request->id]));
                }
            }
        } else if ($type == 'rh') {
            if (can_not_do('human_resource_request')) {
                return back()->with('warning', 'Usted no esta autorizado a aprobar esta solicitud!');
            }

            if ($human_resource_request->approvesup == 'p') {
                return back()->with('info', 'La solicitud no ha sido aprobada por el supervisor!');
            } else {
                if ($human_resource_request->rhuser) {
                    return back()->with('info', 'La solicitud ya ha sido trabajada por RRHH');
                } else {
                    $human_resource_request->approverh = (bool) $to_approve;
                    if ($human_resource_request->reqtype == 'ANT') {
                        $human_resource_request->reqstatus = ($human_resource_request->approverh ? 'En proceso' : 'Rechazado') . ' por RRHH';
                    } else {
                        $human_resource_request->reqstatus = ($human_resource_request->approverh ? 'Aprobado' : 'Rechazado') . ' por RRHH';
                    }
                    $human_resource_request->reasonreje = $human_resource_request->approverh ? '' : $request->reason;
                    $human_resource_request->rhuser = session('employee')->useremp;
                    $human_resource_request->rhname = session('employee')->name;;
                    $human_resource_request->save();

                    Notification::notify('Solicitud de RH', 'Tu solicitud #' . $human_resource_request->reqnumber . ' de RH ha sido ' . ((bool) $to_approve ? 'aprobada' : 'rechazada') . ' por RRHH.', route('human_resources.request.show', ['request' => $human_resource_request->id]), $human_resource_request->created_by);

                    if (in_array($human_resource_request->reqtype, ['PER', 'AUS', 'VAC'])) {
                        Notification::notify('Solicitud de RH', 'La solicitud #' . $human_resource_request->reqnumber . ' de ' . $human_resource_request->colname . ' ha sido ' . ((bool) $to_approve ? 'aprobada' : 'rechazada') . ' por RRHH.', route('human_resources.request.show', ['request' => $human_resource_request->id]), $human_resource_request->colsupuser);
                    }

                    do_log(((bool) $to_approve ? 'Aprob' : 'Rechaz') . 'ó como RRHH la Solicitud de Recursos Humanos ( número:' . strip_tags($human_resource_request->reqnumber) . ' )');
                }
            }
        }

        return back()->with('success', 'La solicitud ha sido ' . ((bool) $to_approve ? 'aprobada' : 'rechazada') . ' correctamente.');
    }

    public function verified(Request $request, $request_id, $to_verified)
    {
        $human_resource_request = HumanResourceRequest::find($request_id);

        $user_info = session()->get('user_info');

        if (can_not_do('human_resource_request')) {
            return back()->with('warning', 'Usted no esta autorizado a aprobar esta solicitud!');
        }

        if ($human_resource_request->approvesup == 'p') {
            return back()->with('info', 'La solicitud no ha sido aprobada por el supervisor!');
        } else {
            if ($human_resource_request->rhuser) {
                return back()->with('info', 'La solicitud ya ha sido trabajada por RRHH');
            } else {
                $human_resource_request->rhverified = (bool) $to_verified;

                if ($human_resource_request->reqtype == 'ANT') {
                    $human_resource_request->reqstatus = ($human_resource_request->rhverified ? 'Verificado' : 'Rechazado') . ' por RRHH';
                } else {
                    $human_resource_request->reqstatus = ($human_resource_request->rhverified ? 'Aprobado' : 'Rechazado') . ' por RRHH';
                }

                $human_resource_request->reasonreje = $human_resource_request->rhverified ? '' : $request->reason;
                $human_resource_request->save();

                Notification::notify('Solicitud de RH', 'Tu solicitud #' . $human_resource_request->reqnumber . ' de RH ha sido ' . ((bool) $to_verified ? 'verificada' : 'rechazada') . ' por RRHH.', route('human_resources.request.show', ['request' => $human_resource_request->id]), $human_resource_request->created_by);

                if (in_array($human_resource_request->reqtype, ['PER', 'AUS', 'VAC'])) {
                    Notification::notify('Solicitud de RH', 'La solicitud #' . $human_resource_request->reqnumber . ' de ' . $human_resource_request->colname . ' ha sido ' . ((bool) $to_verified ? 'verificada' : 'rechazada') . ' por RRHH.', route('human_resources.request.show', ['request' => $human_resource_request->id]), $human_resource_request->colsupuser);
                }

                do_log(((bool) $to_verified ? 'Verific' : 'Rechaz') . 'ó como RRHH la Solicitud de Recursos Humanos ( número:' . strip_tags($human_resource_request->reqnumber) . ' )');
            }
        }

        return back()->with('success', 'La solicitud ha sido ' . ((bool) $to_verified ? 'verificada' : 'rechazada') . ' correctamente.');
    }

    public function changestatus(Request $request)
    {
        $human_resource_request = HumanResourceRequest::find($request->request_id);

        if (!$human_resource_request) {
            return redirect(route('human_resources.request.index'))->with('warning', 'La solicitud no existe!');
        }

        $human_resource_request->reqstatus = $request->status;
        $human_resource_request->save();

        Notification::notify('Solicitud de RH', 'Tu solicitud #' . $human_resource_request->reqnumber . ' de RH ha cambiado al estado (' . $request->status . ')', route('human_resources.request.show', ['request' => $human_resource_request->id]), $human_resource_request->created_by);

        return back()->with('success', 'El estatus ha sido cambiado correctamente');
    }
}
