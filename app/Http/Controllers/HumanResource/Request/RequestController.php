<?php

namespace Bame\Http\Controllers\HumanResource\Request;

use Illuminate\Http\Request;

use DateTime;
use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\HumanResource\Request\Param;
use Bame\Models\HumanResource\Request\HumanResourceRequest;
use Bame\Models\HumanResource\Request\Approval;
use Bame\Models\HumanResource\Request\Detail;
use Bame\Http\Requests\HumanResource\Request\RequestHumanResourceRequest;
use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Calendar\Birthdate;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $params = Param::orderBy('name')->get();

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
            $human_resource_requests->where('coluser', session()->get('user'))
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
            'employee_date' => Birthdate::getOneEmployeeDate(),
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

        $user_info = session()->get('user_info');

        if (in_array($request->type, ['PER', 'VAC', 'ANT'])) {
            $human_resource_request->reqstatus = 'Pendiente por Supervisor';

            $human_resource_request->coluser = session()->get('user');
            $human_resource_request->colcode = $user_info->getPostalCode();
            $human_resource_request->colname = $user_info->getFirstName() . ' ' . $user_info->getLastName();
            $human_resource_request->colposi = $user_info->getTitle();
            $human_resource_request->coldepart = $user_info->getDepartment();

            $human_resource_request->colsupuser = $request->colsupuser;

            if (in_array($request->type, ['PER', 'VAC'])) {
                $human_resource_request->approvesup = false;
            }

            if (in_array($request->type, ['ANT'])) {
                $human_resource_request->reqstatus = 'Pendiente por RRHH';
                $human_resource_request->approvesup = true;
            }
        }

        if (in_array($request->type, ['AUS'])) {
            $human_resource_request->reqstatus = 'Aprobado por Supervisor';

            $human_resource_request->coluser = $request->coluser;
            $human_resource_request->colcode = $request->colcode;
            $human_resource_request->colname = $request->colname;
            $human_resource_request->colposi = $request->colposi;
            $human_resource_request->coldepart = $request->coldepart;

            $human_resource_request->colsupuser = session()->get('user');
            $human_resource_request->colsupname = $user_info->getFirstName() . ' ' . $user_info->getLastName();
            $human_resource_request->colsupposi = $user_info->getTitle();
            $human_resource_request->approvesup = true;
        }

        $human_resource_request->approverh = false;

        $human_resource_request->created_by = session()->get('user');
        $human_resource_request->createname = $user_info->getFirstName() . ' ' . $user_info->getLastName();

        if (in_array($request->type, ['PER', 'AUS'])) {
            $result = self::savePerAusRequest($human_resource_request->id, $request);
        } else if ($request->type == 'VAC') {
            $result = self::saveVacRequest($human_resource_request->id, $request);
        } else if ($request->type == 'ANT') {
            $result = self::saveAntRequest($human_resource_request->id, $request);
        }

        self::attachFiles($human_resource_request->id, $request);

        if ($result) {
            return $result;
        }

        $human_resource_request->reqnumber = get_next_request_rh_number();
        $human_resource_request->save();

        if (in_array($request->type, ['AUS', 'ANT'])) {
            Notification::notifyUsersByPermission('human_resource_request_approverh', 'Solicitud de RH', 'Nueva ' . rh_req_types($human_resource_request->reqtype) . ' creada (#' . $human_resource_request->reqnumber . ') pendiente.', route('human_resources.request.show', ['id' => $human_resource_request->id]));
        } else {
            Notification::notify('Solicitud de RH', 'Tiene un solicitud RH pendiente de aprobación', route('human_resources.request.show', ['request' => $human_resource_request->id]), $request->colsupuser);
        }

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
        $detail->paid = false;

        if ($request->permission_type == 'one_day') {
            $detail->perdatfrom = $request->permission_date;
            $detail->pertimfrom = $request->permission_time_from . ':00';
            $detail->pertimto = $request->permission_time_to . ':00';
        }

        if ($request->permission_type == 'multiple_days') {
            $detail->perdatfrom = $request->permission_date_from;
            $detail->perdatto = $request->permission_date_to;
        }

        if ($request->per == 'otro') {
            $detail->reaforabse = $request->per_reason;
        } else {
            $param = Param::find($request->per);

            if ($param->code == 'DIALIBRE') {
                if (!HumanResourceRequest::isBetweenXDays($request->permission_date)) {
                    return back()->withInput()->with('error', 'El día libre debe ser solicitado al menos con 5 laborables de anticipación');
                }
            }

            $detail->reaforabse = $param->name;
        }

        $detail->created_by = session()->get('user');
        $detail->createname = $user_info->getFirstName() . ' ' . $user_info->getLastName();

        $detail->save();

        return null;
    }

    private static function attachFiles($requestId, $request)
    {
        if ($request->hasFile('files')) {
            $files = collect($request->file('files'));

            $path = storage_path('app\\rrhh_request\\attaches\\' . $requestId . '\\');

            $files->each(function ($file, $index) use ($path) {
                $file_name_destination = str_replace(' ', '_', $file->getClientOriginalName());

                $file_name_destination = remove_accents($file_name_destination);

                $file->move($path, $file_name_destination);
            });
        }
    }

    public function downloadAttach($requestId, $file_name)
    {
        $path = storage_path('app\\rrhh_request\\attaches\\' . $requestId . '\\' . $file_name);

        if (file_exists($path)) {
            return response()->download($path);
        }

        return response('Archivo no encontrado', 404);
    }

    private static function saveVacRequest($requestId, $request)
    {
        if (!HumanResourceRequest::isValidVacDateFrom($request->vac_date_from)) {
            return back()->withInput()->with('error', 'Fecha de Inicio invalida. Favor valide que la misma no sea día feriado ni fin de semana.');
        }

        $user_info = session()->get('user_info');

        $detail = new Detail;

        $detail->id = uniqid(true);
        $detail->req_id = $requestId;
        $detail->vacdatadmi = Birthdate::getOneEmployeeDate();
        $detail->vacdatfrom = $request->vac_date_from;
        $detail->vacdatto = HumanResourceRequest::getVacDateTo($request->vac_date_from, $request->vac_total_days);
        $detail->vactotdays = $request->vac_total_days;
        $detail->vacoutdays = $request->vac_total_pending_days;
        $detail->vacaccbonu = (bool) $request->vac_credited_bonds;
        $detail->note = $request->vac_note;

        $detail->created_by = session()->get('user');
        $detail->createname = $user_info->getFirstName() . ' ' . $user_info->getLastName();

        $detail->save();

        return null;
    }

    private static function saveAntRequest($requestId, $request)
    {
        if (!$request->ant_dues || intval($request->ant_dues) < 1 || intval($request->ant_dues) > 12) {
            return back()->withInput()->with('error', 'Debe colocar la cantidad de cuotas y la misma debe ser entre 1 y 12.');
        }

        $user_info = session()->get('user_info');

        $detail = new Detail;

        $detail->id = uniqid(true);
        $detail->req_id = $requestId;
        $detail->identifica = $request->identification;
        $detail->savaccount = $request->ant_account_number;
        $detail->advamount = round($request->ant_amount, 2);
        $detail->advdues = $request->ant_dues;
        $detail->advdueamou = round(intval($request->ant_amount) / intval($request->ant_dues), 2);

        $detail->created_by = session()->get('user');
        $detail->createname = $user_info->getFirstName() . ' ' . $user_info->getLastName();

        $detail->save();

        return null;
    }

    public function excel(Request $request)
    {
        $human_resource_requests = HumanResourceRequest::lastestFirst();

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

        do_log('Exportó a Excel las Solicitudes de RRHH ( desde:' . strip_tags($request->date_from) . ' hasta:' . strip_tags($request->date_to) . ' )');

        return view('human_resources.request.export.excel')
            ->with('rrhh_requests', $human_resource_requests->get());
    }

    public function paid(Request $request, $requestId)
    {
        $human_resource_request = HumanResourceRequest::find($requestId);

        $human_resource_request->detail()->update([
            'paid' => (bool) $request->paid,
        ]);

        return back()->with('success', 'Los cambios han sido guardados correctamente.');
    }

    public function saveVacRHForm(Request $request, $requestId)
    {
        $human_resource_request = HumanResourceRequest::find($requestId);

        $human_resource_request->detail()->update([
            'dayscorres' => $request->vac_day_corresponding,
            'daystakedm' => $request->vac_day_taken_at_moment,
            'dayspendin' => $request->vac_day_pending,
            'applybonus' => (bool) $request->applybonus,
            'datebonus' => $request->vac_date_bonus,
            'datebonusd' => $request->vac_date_bonus_sd,
        ]);

        return back()->with('success', 'Los cambios han sido guardados correctamente.');
    }

    public function saveAntRHForm(Request $request, $requestId)
    {
        $human_resource_request = HumanResourceRequest::find($requestId);

        $human_resource_request->detail()->update([
            'clientnum' => $request->client_number,
            'advnumber' => $request->ant_advance_number,
            'advdatdepo' => $request->ant_deposit_date,
            'firsduedat' => $request->ant_first_due_date,
            'lastduedat' => $request->ant_last_due_date,
            'note' => $request->ant_note,
        ]);

        return back()->with('success', 'Los cambios han sido guardados correctamente.');
    }
}
