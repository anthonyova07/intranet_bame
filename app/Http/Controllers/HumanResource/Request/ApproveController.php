<?php

namespace Bame\Http\Controllers\HumanResource\Request;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\HumanResource\Request\Param;
use Bame\Models\HumanResource\Request\HumanResourceRequest;

class ApproveController extends Controller
{
    public function approve(Request $request, $request_id, $to_approve, $type)
    {
        // dd($request_id, $to_approve, $type);

        $human_resource_request = HumanResourceRequest::find($request_id);

        if (!$human_resource_request || !in_array($type, ['sup', 'rh'])) {
            return redirect(route('human_resources.request.index'))->with('warning', 'La solicitud no existe!');
        }

        $user_info = session()->get('user_info');

        if ($type == 'sup') {
            if ($human_resource_request->colsupuser != session()->get('user')) {
                return back()->with('warning', 'Usted no esta autorizado a aprobar esta solicitud!');
            }

            if ($human_resource_request->colsupname) {
                return back()->with('info', 'La solicitud ya ha sido trabajada por el supervisor');
            } else {
                $human_resource_request->approvesup = (bool) $to_approve;
                $human_resource_request->colsupname = $user_info->getFirstName() . ' ' . $user_info->getLastName();
                $human_resource_request->colsupposi = $user_info->getTitle();
                $human_resource_request->save();

                Notification::notify('Solicitud de RH', 'Tú solicitud #' . $human_resource_request->reqnumber . ' de RH ha sido ' . ((bool) $to_approve ? 'aprobada' : 'rechazada') . ' por tu supervisor.', route('human_resources.request.show', ['request' => $human_resource_request->id]), $human_resource_request->created_by);
            }
        } else if ($type == 'rh') {
            if (can_not_do('human_resource_request_approverh')) {
                return back()->with('warning', 'Usted no esta autorizado a aprobar esta solicitud!');
            }

            if (!$human_resource_request->approvesup) {
                return back()->with('info', 'La solicitud no ha sido aprobada por el supervisor!');
            } else {
                if ($human_resource_request->rhuser) {
                    return back()->with('info', 'La solicitud ya ha sido trabajada por el supervisor');
                } else {
                    $human_resource_request->approverh = (bool) $to_approve;
                    $human_resource_request->rhuser = session()->get('user');
                    $human_resource_request->rhname = $user_info->getFirstName() . ' ' . $user_info->getLastName();
                    $human_resource_request->save();

                    Notification::notify('Solicitud de RH', 'Tú solicitud #' . $human_resource_request->reqnumber . ' de RH ha sido ' . ((bool) $to_approve ? 'aprobada' : 'rechazada') . ' por RRHH.', route('human_resources.request.show', ['request' => $human_resource_request->id]), $human_resource_request->created_by);

                    Notification::notify('Solicitud de RH', 'La solicitud #' . $human_resource_request->reqnumber . ' de ' . $human_resource_request->colname . ' ha sido ' . ((bool) $to_approve ? 'aprobada' : 'rechazada') . ' por RRHH.', route('human_resources.request.show', ['request' => $human_resource_request->id]), $human_resource_request->created_by);
                }
            }
        }

        return back()->with('success', 'La solicitud ha sido ' . ((bool) $to_approve ? 'aprobada' : 'rechazada') . ' correctamente.');
    }

    public function changestatus(Request $request)
    {
        $human_resource_request = HumanResourceRequest::find($request->request_id);

        if (!$human_resource_request) {
            return redirect(route('human_resources.request.index'))->with('warning', 'La solicitud no existe!');
        }

        $status = Param::where('type', 'EST')->where('id', $request->status)->first();

        $human_resource_request->reqstatus = $status->name;
        $human_resource_request->save();

        return back()->with('success', 'El estatus ha sido cambiado correctamente');
    }
}
