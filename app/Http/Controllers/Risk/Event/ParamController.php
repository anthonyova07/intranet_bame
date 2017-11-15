<?php

namespace Bame\Http\Controllers\Risk\Event;

use Bame\Http\Events;
use Illuminate\Http\Event;
use Bame\Models\Risk\Event\Param;
use Bame\Http\Controllers\Controller;
use Bame\Http\Requests\Risk\Event\ParamRiskEvent;

class ParamController extends Controller
{
    public function create($type)
    {
        return view('risk.event.param.create')
            ->with('type', $type);
    }

    public function store(ParamRiskEvent $request, $type)
    {
        $param = new Param;

        $param->id = uniqid(true);
        $param->type = $type;
        $param->code = strtoupper($request->code);
        $param->note = cap_str($request->description);

        $param->is_active = $request->is_active ? true : false;
        $param->created_by = session()->get('user');

        $param->save();

        do_log('Creó el parametro ' . get_risk_event_params($type) . ' en Eventos de Riesgo Operacional ( código:' . strip_tags($param->code) . ' )');

        return redirect()->route('risk.event.{type}.param.create', ['type' => $type])
            ->with('success', 'El ' . get_risk_event_params($type) . ' fue creado correctamente.');
    }

    public function edit($type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . get_risk_event_params($type) . ' no existe!');
        }

        return view('risk.event.param.edit')
            ->with('param', $param);
    }

    public function update(ParamRiskEvent $request, $type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . get_risk_event_params($type) . ' no existe!');
        }

        $param->code = strtoupper($request->code);
        $param->note = cap_str($request->description);

        $param->is_active = $request->is_active ? true : false;
        $param->updated_by = session()->get('user');

        $param->save();

        do_log('Modificó el parametro ' . get_risk_event_params($type) . ' en Eventos de Riesgo Operacional ( código:' . strip_tags($param->code) . ' )');

        return redirect()->route('risk.event.index')
            ->with('success', 'El ' . get_risk_event_params($type) . ' fue modificado correctamente.');
    }
}
