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
        $process_requests = TdcRequest::lastestFirst();

        // if ($request->term) {
        //     $term = cap_str($request->term);
        //
        //     $process_requests = $process_requests->orWhere('reqnumber', 'like', '%' . $term . '%')
        //                 ->orWhere('reqtype', 'like', '%' . $term . '%')
        //                 ->orWhere('process', 'like', '%' . $term . '%')
        //                 ->orWhere('note', 'like', '%' . $term . '%')
        //                 ->orWhere('causeanaly', 'like', '%' . $term . '%')
        //                 ->orWhere('peoinvolve', 'like', '%' . $term . '%');
        // }
        //
        // if ($request->request_type) {
        //     $process_requests->where('reqtype', $request->request_type);
        // }
        //
        // if ($request->process) {
        //     $process_requests->where('process', $request->process);
        // }
        //
        // if ($request->date_from) {
        //     $process_requests->where('created_at', '>=', $request->date_from . ' 00:00:00');
        // }
        //
        // if ($request->date_to) {
        //     $process_requests->where('created_at', '<=', $request->date_to . ' 23:59:59');
        // }

        return view('customer.requests.tdc.index', [
            'process_requests' => $process_requests->get(),
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
        $request_tdc->papartmen = $request->papartment;
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
        $request_tdc->lapartmen = $request->lapartment;
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

        return redirect(route('process.request.show', ['request' => $request_tdc->id]))->with('success', 'La solicitud ha sido creada correctamente.');

    }

    public function show($request)
    {
        $process_request = TdcRequest::find($request);

        if (!$process_request) {
            return redirect(route('process.request.index'));
        }

        do_log('Consultó la Solicitud de Procesos ( número:' . strip_tags($process_request->reqnumber) . ' )');

        return view('process.request.show', [
            'process_request' => $process_request,
        ]);
    }
}
