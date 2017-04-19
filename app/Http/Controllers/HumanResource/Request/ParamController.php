<?php

namespace Bame\Http\Controllers\HumanResource\Request;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\HumanResource\Request\Param;
use Bame\Http\Requests\HumanResource\Request\ParamRequest;

class ParamController extends Controller
{
    public function create($type)
    {
        if (!array_key_exists($type, rh_req_types()->toArray())) {
            return redirect(route('human_resources.request.create'))->with('warning', 'El tipo de solicitud seleccionado no existe.');
        }

        return view('human_resources.request.param.create')
            ->with('type', $type);
    }

    public function store(ParamRequest $request, $type)
    {
        $param = new Param;

        $param->id = uniqid(true);
        $param->type = $type;
        $param->code = strtoupper($request->code);
        $param->name = cap_str($request->name);

        do_log('Creó el parametro ' . rh_req_types($type) . ' en Solicitudes de Recursos Humanos ( código:' . strip_tags($param->code) . ' )');

        $param->is_active = $request->is_active ? true : false;
        $param->created_by = session()->get('user');

        $param->save();

        return redirect(route('human_resources.request.{type}.param.create', ['type' => $type]))
            ->with('success', 'El ' . rh_req_types($type) . ' fue creado correctamente.');
    }

    public function edit($type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . rh_req_types($type) . ' no existe!');
        }

        return view('human_resources.request.param.edit')
            ->with('param', $param);
    }

    public function update(ParamRequest $request, $type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . rh_req_types($type) . ' no existe!');
        }

        $param->code = strtoupper($request->code);
        $param->name = cap_str($request->name);

        do_log('Modificó el parametro ' . rh_req_types($type) . ' en Solicitudes de Recursos Humanos ( código:' . strip_tags($param->code) . ' )');

        $param->is_active = $request->is_active ? true : false;
        $param->updated_by = session()->get('user');

        $param->save();

        return redirect(route('human_resources.request.index'))
            ->with('success', 'El ' . rh_req_types($type) . ' fue modificado correctamente.');
    }
}
