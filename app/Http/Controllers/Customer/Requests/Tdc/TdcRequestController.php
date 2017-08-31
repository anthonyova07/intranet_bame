<?php

namespace Bame\Http\Controllers\Customer\Requests\Tdc;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\HumanResource\Employee\Employee;
use Bame\Models\Customer\Requests\Tdc\TdcRequest;
use Bame\Models\Customer\Requests\Tdc\CustomerProcessed;
use Bame\Models\Customer\Requests\Tdc\Param;
use Bame\Http\Requests\Customer\Requests\Tdc\RequestTdcRequest;
use Bame\Models\Notification\Notification;

class TdcRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests_tdc = TdcRequest::lastestFirst();

        if ($request->term) {
            $term = $request->term;

            $requests_tdc->orWhere('reqnumber', 'like', '%' . $term . '%')
                        ->orWhere('names', 'like', '%' . $term . '%')
                        ->orWhere('identifica', 'like', '%' . $term . '%')
                        ->orWhere('pphone_res', 'like', '%' . $term . '%')
                        ->orWhere('pphone_cel', 'like', '%' . $term . '%');
        }

        if ($request->date_from) {
            $requests_tdc->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $requests_tdc->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        return view('customer.requests.tdc.index', [
            'params' => Param::get(),
            'requests_tdc' => $requests_tdc->paginate(),
        ]);
    }

    public function create(Request $request, $is_extranet = false)
    {
        $customer = null;

        if ($request->identification) {
            $customer = TdcRequest::searchFromDBFile($request->identification);

            if (!$customer) {
                return back()->with('warning', 'El cliente no ha sido encontrado o no se ha cargado la base de datos para el canal: ' . Employee::getChannel(true));
            }

            $customer_processed = CustomerProcessed::byIdentification($customer->identification)->lastestFirst()->first();

            if ($customer_processed) {
                if ($customer_processed->hasRequestCreated()) {
                    return redirect()->route('customer.request.tdc.create')->with('warning', 'Este cliente ya tiene una solicitud creada.');
                }

                if ($customer_processed->isBlack()) {
                    return redirect()->route('customer.request.tdc.create')->with('error', 'Este cliente ya no puede ser contactado por: ' . $customer_processed->denail->note);
                }

                if ($customer_processed->hasDenail()) {
                    session()->flash('info', 'Este cliente ya fue contactado y rechazó por: ' . $customer_processed->denail->note);
                }
            }

            session()->put('customer_request_tdc', $customer);
        }

        $denails = collect();

        if (!$is_extranet) {
            if ($request->accept == 'no') {
                $denails = Param::denails()->get();
            }

            return view('customer.requests.tdc.create', [
                'customer' => $customer,
                'denails' => $denails,
                'accept' => $request->accept
            ]);
        } else {
            return $customer;
        }
    }

    public function store(RequestTdcRequest $request, $is_extranet = false)
    {
        $request_tdc = new TdcRequest;

        if (!session()->has('customer_request_tdc')) {
            return back()->withInput()->withError('El cliente no ha sido cargado. Favor intentar cargarlo nuevamente.');
        }

        $customer = session('customer_request_tdc');

        $request_tdc->id = uniqid(strtolower(Employee::getChannel()).'_', true);
        $request_tdc->channel = Employee::getChannel();
        $request_tdc->reqstatus = 'Pendiente de Aprobación';

        $request_tdc->producttyp = $customer->product;
        $request_tdc->limitrd = $customer->limit_rd;
        $request_tdc->limitus = $customer->limit_us;
        $request_tdc->senddirpla = $request->send_dir_plastic;
        $request_tdc->plastiname = strtoupper(trim($request->plastic_name));

        $request_tdc->names = utf8_encode($customer->names);
        $request_tdc->identifica = $customer->identification;
        $request_tdc->birthdate = $customer->birthdate;
        $request_tdc->nationalit = $customer->nationality;
        $request_tdc->gender = $customer->gender;
        $request_tdc->maristatus = $request->marital_status;

        $request_tdc->pstreet = $request->pstreet;
        $request_tdc->pnum = $request->pnum;
        $request_tdc->pbuilding = $request->pbuilding;
        $request_tdc->papartment = $request->papartment;
        $request_tdc->psector = $request->psector;
        $request_tdc->pcountry = 'República Dominicana';
        $request_tdc->pmail = $request->pmail;
        $request_tdc->pnear = $request->pnear;
        $request_tdc->pschedule = $request->pschedule;
        $request_tdc->pphone_res = $request->parea_code_res.$request->pphone_res;
        $request_tdc->pphone_cel = $request->parea_code_cel.$request->pphone_cel;

        $request_tdc->businename = $request->business_name;
        $request_tdc->position = $request->position;
        $request_tdc->workintime = $request->working_time;
        $request_tdc->montincome = $request->monthly_income;
        $request_tdc->otheincome = $request->others_income;

        $request_tdc->lstreet = $request->lstreet;
        $request_tdc->lnum = $request->lnum;
        $request_tdc->lbuilding = $request->lbuilding;
        $request_tdc->lapartment = $request->lapartment;
        $request_tdc->lsector = $request->lsector;
        $request_tdc->lcountry = 'República Dominicana';
        $request_tdc->lmail = $request->lmail;
        $request_tdc->lnear = $request->lnear;
        $request_tdc->lschedule = $request->lschedule;
        $request_tdc->lphone_off = $request->larea_code_off.$request->lphone_off;
        $request_tdc->lphone_ext = $request->lphone_ext;
        $request_tdc->lphone_fax = $request->larea_code_fax.$request->lphone_fax;

        $request_tdc->ref1names = $request->ref_1_name;
        $request_tdc->ref1phores = $request->area_code_ref1_res.$request->ref_1_phone_res;
        $request_tdc->ref1phocel = $request->area_code_ref1_cel.$request->ref_1_phone_cel;

        $request_tdc->ref2names = $request->ref_2_name;
        $request_tdc->ref2phores = $request->area_code_ref2_res.$request->ref_2_phone_res;
        $request_tdc->ref2phocel = $request->area_code_ref2_cel.$request->ref_2_phone_cel;

        $request_tdc->campaign = $customer->campaign;
        $request_tdc->committee = $customer->committee;
        $request_tdc->commitdate = $customer->committee_date;

        if ($is_extranet) {
            $request_tdc->created_by = auth()->user()->username;
            $request_tdc->createname = auth()->user()->full_name;
        } else {
            $request_tdc->created_by = session()->get('user');
            $request_tdc->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
        }

        $request_tdc->reqnumber = get_next_request_tdc_number();
        $request_tdc->save();

        $this->located($request, $customer->identification, $request_tdc->reqnumber, $is_extranet);

        if ($is_extranet) {
            return $request_tdc;
        } else {
            do_log('Creó la Solicitud de Tarjeta ( número:' . strip_tags($request_tdc->reqnumber) . ' )');

            return redirect(route('customer.request.tdc.show', [$request_tdc->id]))->with('success', 'La solicitud ha sido creada correctamente.');
        }
    }

    public function show($tdc)
    {
        $request_tdc = TdcRequest::find($tdc);

        if (!$request_tdc) {
            return redirect(route('process.request.index'));
        }

        do_log('Consultó la Solicitud de Procesos ( número:' . strip_tags($request_tdc->reqnumber) . ' )');

        return view('customer.requests.tdc.show', [
            'request_tdc' => $request_tdc,
        ]);
    }

    public function print(Request $request)
    {
        $ids = explode(',', $request->id);

        $requests_tdc = TdcRequest::whereIn('id', $ids)->get();

        return view('customer.requests.tdc.print')
            ->with('requests_tdc', $requests_tdc);
    }

    public function located(Request $request, $identification, $reqnumber = null, $is_extranet = false)
    {
        $customer = session('customer_request_tdc');

        $denail = Param::denails()->find($request->denail);

        $customer_processed = new CustomerProcessed;

        $customer_processed->id = uniqid(true);

        if ($denail) {
            $customer_processed->denail_id = $denail->id;
            $customer_processed->is_black = $denail->isblack;
        } else {
            $customer_processed->denail_id = null;
            $customer_processed->is_black = 0;
        }

        $customer_processed->reqnumber = $reqnumber;
        $customer_processed->channel = Employee::getChannel();
        $customer_processed->producttyp = $customer->product;
        $customer_processed->limitrd = $customer->limit_rd;
        $customer_processed->limitus = $customer->limit_us;
        $customer_processed->names = utf8_encode($customer->names);
        $customer_processed->identifica = $customer->identification;
        $customer_processed->birthdate = $customer->birthdate;
        $customer_processed->nationalit = $customer->nationality;
        $customer_processed->gender = $customer->gender;

        $customer_processed->celular_1 = $customer->phones_cel[0];
        $customer_processed->celular_2 = $customer->phones_cel[1];
        $customer_processed->celular_3 = $customer->phones_cel[2];

        $customer_processed->house_1 = $customer->phones_house[0];
        $customer_processed->house_2 = $customer->phones_house[1];
        $customer_processed->house_3 = $customer->phones_house[2];

        $customer_processed->work_1 = $customer->phones_work[0];
        $customer_processed->work_2 = $customer->phones_work[1];
        $customer_processed->work_3 = $customer->phones_work[2];

        $customer_processed->other_1 = $customer->phones_other[0];
        $customer_processed->other_2 = $customer->phones_other[1];
        $customer_processed->other_3 = $customer->phones_other[2];

        $customer_processed->campaign = $customer->campaign;
        $customer_processed->committee = $customer->committee;
        $customer_processed->commitdate = $customer->committee_date;

        if ($is_extranet) {
            $customer_processed->created_by = auth()->user()->username;
            $customer_processed->createname = auth()->user()->full_name;
        } else {
            $customer_processed->created_by = session()->get('user');
            $customer_processed->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

            do_log('Procesó al Cliente para Sol. de TDC ( identificación:' . strip_tags($customer->identification) . ' )');
        }

        $customer_processed->save();

        if ($is_extranet) {
            return $customer_processed;
        } else {
            return redirect(route('customer.request.tdc.create'))->with('success', 'El cliente ha sido procesado correctamente.');
        }
    }

    public function excel(Request $request)
    {
        $customers = CustomerProcessed::lastestFirst();

        if ($request->date_from) {
            $customers->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $customers->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        do_log('Exportó a Excel los clientes gestionados en las solicitudes tdc ( desde:' . strip_tags($request->date_from) . ' hasta:' . strip_tags($request->date_to) . ' )');

        return view('customer.requests.tdc.excel')
            ->with('customers', $customers->get());
    }
}
