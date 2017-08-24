<?php

namespace Bame\Http\Controllers\Customer\Requests\Tdc;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\Customer\Requests\Tdc\TdcRequest;
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
            $process_requests->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $process_requests->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        return view('customer.requests.tdc.index', [
            'requests_tdc' => $requests_tdc->paginate(),
        ]);
    }

    public function create(Request $request)
    {
        $customer = null;

        if ($request->identification) {
            $customer = TdcRequest::searchFromDBFile($request->identification);

            if (!$customer) {
                return back()->with('warning', 'El cliente no ha sido encontrado o no se ha cargado la base de datos.');
            }
        }

        session()->put('customer_request_tdc', $customer);

        return view('customer.requests.tdc.create', [
            'customer' => $customer,
        ]);
    }

    public function store(RequestTdcRequest $request)
    {
        $request_tdc = new TdcRequest;

        if (!session()->has('customer_request_tdc')) {
            return back()->withInput()->withError('El cliente no ha sido cargado. Favor intentar cargarlo nuevamente.');
        }

        $customer = session('customer_request_tdc');

        $request_tdc->id = uniqid(true);
        $request_tdc->channel = '';
        $request_tdc->reqstatus = 'Pendiente de Aprobación';

        $request_tdc->producttyp = $customer->product;
        $request_tdc->limitrd = $customer->limit_rd;
        $request_tdc->limitus = $customer->limit_us;
        $request_tdc->senddirpla = $request->send_dir_plastic;
        $request_tdc->plastiname = $request->plastic_name;

        $request_tdc->names = $customer->names;
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
        $request_tdc->pcountry = $request->pcountry;
        $request_tdc->pmail = $request->pmail;
        $request_tdc->pnear = $request->pnear;
        $request_tdc->pschedule = $request->pschedule;
        $request_tdc->pphone_res = $request->pphone_res;
        $request_tdc->pphone_cel = $request->pphone_cel;

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
        $request_tdc->lcountry = $request->lcountry;
        $request_tdc->lmail = $request->lmail;
        $request_tdc->lnear = $request->lnear;
        $request_tdc->lschedule = $request->lschedule;
        $request_tdc->lphone_off = $request->lphone_off;
        $request_tdc->lphone_ext = $request->lphone_ext;
        $request_tdc->lphone_fax = $request->lphone_fax;

        $request_tdc->ref1names = $request->ref_1_name;
        $request_tdc->ref1phores = $request->ref_1_phone_res;
        $request_tdc->ref1phocel = $request->ref_1_phone_cel;

        $request_tdc->ref2names = $request->ref_2_name;
        $request_tdc->ref2phores = $request->ref_2_phone_res;
        $request_tdc->ref2phocel = $request->ref_2_phone_cel;

        $request_tdc->created_by = session()->get('user');
        $request_tdc->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $request_tdc->reqnumber = get_next_request_tdc_number();
        $request_tdc->save();

        do_log('Creó la Solicitud de Tarjeta ( número:' . strip_tags($request_tdc->reqnumber) . ' )');

        return redirect(route('customer.request.tdc.show', [$request_tdc->id]))->with('success', 'La solicitud ha sido creada correctamente.');

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
}
