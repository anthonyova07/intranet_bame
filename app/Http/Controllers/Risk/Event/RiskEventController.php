<?php

namespace Bame\Http\Controllers\Risk\Event;

use Carbon\Carbon;
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
        $risk_events = RiskEvent::eventsOnly()->lastestFirst();

        if ($request->term) {
            $term = $request->term;

            $risk_events = $risk_events->where(function ($query) use ($term) {
                $query->orWhere('event_code', 'like', '%' . $term . '%')
                    ->orWhere('descriptio', 'like', '%' . $term . '%')
                    ->orWhere('consequenc', 'like', '%' . $term . '%')
                    ->orWhere('assoc_cont', 'like', '%' . $term . '%');
            });
        }

        if ($request->date_from) {
            $risk_events->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $risk_events->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $risk_events = $risk_events->paginate();

        $params = Param::get();

        return view('risk.event.index', [
            'risk_events' => $risk_events,
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

        return redirect()->route('risk.event.show', ['request' => $risk_event->id])->with('success', 'El evento ha sido creado correctamente.');

    }

    public function show($request)
    {
        $risk_event = RiskEvent::find($request);

        if (!$risk_event) {
            return redirect()->route('risk.event.index');
        }

        do_log('Consultó el Evento de Riesgo Operacional ( número:' . $risk_event->id . ' )');

        $params = Param::activeOnly()->get();

        return view('risk.event.show', [
            'risk_event' => $risk_event,
            'params' => $params,
        ]);
    }

    public function mark_event(Request $request, $risk_event, $is_event)
    {
        $risk_event = RiskEvent::find($risk_event);

        if (!$risk_event) {
            return back()->with('warning', 'El evento no existe.');
        }

        if ($risk_event->is_event != null) {
            return back()->with('warning', 'El evento ya ha sido marcado.');
        }

        $risk_event->is_event = $is_event == '1';

        if ($risk_event->is_event) {
            $risk_event->event_code = get_next_risk_event_number();
        }

        $risk_event->save();

        do_log('Marcó el Evento de Riesgo Operacional ( id:'.$risk_event->id.', codigo:'.$risk_event->event_code.', como:' . ($risk_event->is_event ? 'es evento' : ' no es evento') . ' )');

        return back()->with('success', 'El evento ha sido marcado como '.($risk_event->is_event ? 'evento' : ' no evento').' correctamente.');
    }

    public function save_evaluation(Request $request, $risk_event)
    {
        $this->validate($request, [
            'loss_type' => 'required',
            'risk_link' => 'required',
            'risk_factor' => 'required',
            'event_start' => 'required',
            'event_end' => 'required',
            'event_disc' => 'required',
        ]);

        $risk_event = RiskEvent::find($risk_event);

        if (!$risk_event) {
            return back()->with('warning', 'El evento no existe.');
        }

        $risk_event->loss_type = $request->loss_type;
        $risk_event->risk_link = $request->risk_link;
        $risk_event->risk_facto = $request->risk_factor;
        $risk_event->event_star = $request->event_start;
        $risk_event->event_end = $request->event_end;
        $risk_event->event_disc = $request->event_disc;

        $risk_event->rcreatedby = session()->get('user');
        $risk_event->rcreatenam = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
        $risk_event->rcreatedat = $datetime = (new Carbon);

        $risk_event->save();

        do_log('Guardó Información de Evaluacion del Evento de Riesgo Operacional ( id:'.$risk_event->id.', codigo:'.$risk_event->event_code.', como:' . ($risk_event->is_event ? 'es evento' : ' no es evento') . ' )');

        return back()->with('success', 'La información de evaluación del evento ha sido modificada correctamente.');
    }

    public function save_accounting(Request $request, $risk_event)
    {
        $this->validate($request, [
            'post_date' => 'required',
            'account' => 'required|numeric',
            'amount_nac' => 'required|numeric',
            'amount_ori' => 'required|numeric',
            'amount_ins' => 'required|numeric',
            'amount_rec' => 'required|numeric',
        ]);

        $risk_event = RiskEvent::find($risk_event);

        if (!$risk_event) {
            return back()->with('warning', 'El evento no existe.');
        }

        $risk_event->post_date = $request->post_date;
        $risk_event->account = $request->account;
        $risk_event->amount_nac = $request->amount_nac;
        $risk_event->amount_ori = $request->amount_ori;
        $risk_event->amount_ins = $request->amount_ins;
        $risk_event->amount_rec = $request->amount_rec;

        $risk_event->ccreatedby = session()->get('user');
        $risk_event->ccreatenam = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
        $risk_event->ccreatedat = $datetime = (new Carbon);

        $risk_event->save();

        do_log('Guardó Información de Contabilización del Evento de Riesgo Operacional ( id:'.$risk_event->id.', codigo:'.$risk_event->event_code.' )');

        return back()->with('success', 'La información de evaluación del evento ha sido modificada correctamente.');
    }

    public function excel(Request $request, $report)
    {
        $risk_events = RiskEvent::eventsOnly()->lastestFirst();

        if ($request->date_from) {
            $risk_events->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $risk_events->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $risk_events = $risk_events->get();

        return view('risk.event.excel.'.$report, compact('risk_events'));
    }
}
