<?php

namespace Bame\Http\Controllers\HumanResource\Request;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\HumanResource\Request\Param;
use Bame\Models\HumanResource\Request\HumanResourceRequest;
use Bame\Models\HumanResource\Request\Approval;
use Bame\Models\HumanResource\Request\Detail;
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

            $human_resource_requests = $human_resource_requests->where(function ($query) use ($term) {
                $query->orWhere('reqnumber', 'like', '%' . $term . '%')
                        ->orWhere('colcode', 'like', '%' . $term . '%')
                        ->orWhere('colname', 'like', '%' . $term . '%')
                        ->orWhere('colposi', 'like', '%' . $term . '%')
                        ->orWhere('coldepart', 'like', '%' . $term . '%');
            });
        }

        if ($request->reqtype && $request->reqtype != 'todos') {
            $human_resource_requests->where('reqtype', $request->reqtype);
        }

        if ($request->status && $request->status != 'todos') {
            $human_resource_requests->where('reqstatus', $request->status);
        }

        if ($request->date_from) {
            $human_resource_requests->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $human_resource_requests->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        if (can_not_do('human_resource_request_approverh')) {
            $human_resource_requests->where('created_by', session()->get('user'))
                ->orWhere('colsupuser', session()->get('user'));
        }

        $human_resource_requests =  $human_resource_requests->paginate();

        return view('human_resources.request.index', [
            'human_resource_requests' => $human_resource_requests,
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
        if ($request->type) {
            if (!array_key_exists($request->type, rh_req_types()->toArray())) {
                return redirect(route('human_resources.request.create'))->with('warning', 'El tipo de solicitud seleccionado no existe.');
            }
        }

        $human_resource_request = new HumanResourceRequest;

        $human_resource_request->id = uniqid(true);
        $human_resource_request->reqtype = $request->type;
        $human_resource_request->reqstatus = 'Pendiente';

        $user_info = session()->get('user_info');

        $human_resource_request->coluser = session()->get('user');
        $human_resource_request->colcode = $user_info->getPostalCode();
        $human_resource_request->colname = $user_info->getFirstName() . ' ' . $user_info->getLastName();
        $human_resource_request->colposi = $user_info->getTitle();
        $human_resource_request->coldepart = $user_info->getDepartment();

        $human_resource_request->colsupuser = $request->colsupuser;
        $human_resource_request->approvesup = false;

        $human_resource_request->approverh = false;

        $human_resource_request->created_by = session()->get('user');
        $human_resource_request->createname = $user_info->getFirstName() . ' ' . $user_info->getLastName();

        if ($request->type == 'PERAUS') {
            self::savePerAusRequest($human_resource_request->id, $request);
        } else if ($request->type == 'VAC') {
            if (HumanResourceRequest::isValidVacDateFrom($request->vac_date_from)) {
                self::saveVacRequest($human_resource_request->id, $request);
            } else {
                return back()->withInput()->with('error', 'Fecha de Inicio invalida. Favor valide que la misma no sea día feriado ni fin de semana.');
            }
        }

        $human_resource_request->reqnumber = get_next_request_rh_number();
        $human_resource_request->save();

        Notification::notify('Solicitud de RH', 'Tiene un solicitud RH pendiente de aprobación', route('human_resources.request.show', ['request' => $human_resource_request->id]), $request->colsupuser);

        do_log('Creó la Solicitud de Recursos Humanos ( número:' . strip_tags($human_resource_request->reqnumber) . ' )');

        return redirect(route('human_resources.request.show', ['request' => $human_resource_request->id]))->with('success', 'La solicitud ha sido creada correctamente.');

    }

    public function show($request)
    {
        $human_resource_request = HumanResourceRequest::find($request);

        if (!$human_resource_request) {
            return redirect(route('human_resources.request.index'));
        }

        $statuses = Param::where('type', 'EST')->activeOnly()->get();

        do_log('Consultó la Solicitud de Recursos Humanos ( número:' . strip_tags($human_resource_request->reqnumber) . ' )');

        return view('human_resources.request.show', [
            'human_resource_request' => $human_resource_request,
            'statuses' => $statuses,
        ]);
    }

    private static function savePerAusRequest($requestId, $request)
    {
        $user_info = session()->get('user_info');

        $detail = new Detail;

        $detail->id = uniqid(true);
        $detail->req_id = $requestId;
        $detail->pertype = $request->permission_type;
        if ($request->permission_type == 'one_day') {
            $detail->perdatfrom = $request->permission_date;
            $detail->pertimfrom = $request->permission_time_from . ':00';
            $detail->pertimto = $request->permission_time_to . ':00';
        }

        if ($request->permission_type == 'multiple_days') {
            $detail->perdatfrom = $request->permission_date_from;
            $detail->perdatto = $request->permission_date_to;
        }

        if ($request->peraus == 'otro') {
            $detail->reaforabse = $request->peraus_reason;
        } else {
            $param = Param::find($request->peraus);
            $detail->reaforabse = $param->name;
        }

        $detail->created_by = session()->get('user');
        $detail->createname = $user_info->getFirstName() . ' ' . $user_info->getLastName();

        $detail->save();
    }

    private static function saveVacRequest($requestId, $request)
    {
        $user_info = session()->get('user_info');

        $detail = new Detail;

        $detail->id = uniqid(true);
        $detail->req_id = $requestId;
        $detail->vacdatadmi = $request->vac_date_admission;
        $detail->vacdatfrom = $request->vac_date_from;
        $detail->vacdatto = HumanResourceRequest::getVacDateTo($request->vac_date_from, $request->vac_total_days);
        $detail->vactotdays = $request->vac_total_days;
        $detail->vacoutdays = $request->vac_total_pending_days;
        $detail->vacaccbonu = (bool) $request->vac_credited_bonds;
        $detail->note = $request->vac_note;

        $detail->created_by = session()->get('user');
        $detail->createname = $user_info->getFirstName() . ' ' . $user_info->getLastName();

        $detail->save();
    }
}
