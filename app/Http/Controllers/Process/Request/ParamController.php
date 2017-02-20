<?php

namespace Bame\Http\Controllers\Process\Request;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Process\Request\Param;
use Bame\Http\Requests\Process\Request\ParamRequest;

class ParamController extends Controller
{
    public function create($type)
    {
        $process = collect();

        if ($type == 'PRO') {
            $process = Param::where('type', 'PRO')->where('id_parent', '')->get();
        }

        return view('process.request.param.create')
            ->with('process', $process)
            ->with('type', $type);
    }

    public function store(ParamRequest $request, $type)
    {
        $param = new Param;

        $param->id = uniqid(true);
        $param->type = $type;
        $param->code = strtoupper($request->code);

        if ($type == 'PRO') {
            $param->id_parent = $request->process_parent;
            $param->version = $request->version;
            $param->name = cap_str($request->name);
        } else {
            $param->note = cap_str($request->description);
        }

        do_log('Creó el parametro ' . get_proreq_param($type, false) . ' en Solicitudes de Procesos ( código:' . strip_tags($param->code) . ' )');

        $param->is_active = $request->is_active ? true : false;
        $param->created_by = session()->get('user');

        $param->save();

        return redirect(route('process.request.{type}.param.create', ['type' => $type]))
            ->with('success', 'El ' . get_proreq_param($type, false) . ' fue creado correctamente.');
    }

    public function edit($type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . get_proreq_param($type, false) . ' no existe!');
        }

        $process = collect();

        if ($type == 'PRO') {
            $process = Param::where('type', 'PRO')->where('id_parent', '')->where('id', '<>', $param->id)->get();
        }

        return view('process.request.param.edit')
            ->with('process', $process)
            ->with('param', $param);
    }

    public function update(ParamRequest $request, $type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . get_proreq_param($type, false) . ' no existe!');
        }

        $param->code = strtoupper($request->code);

        if ($type == 'PRO') {
            $parem->id_parent = $request->process_parent;
            $param->version = $request->version;
            $param->name = cap_str($request->name);
        } else {
            $param->note = cap_str($request->description);
        }

        do_log('Modificó el parametro ' . get_proreq_param($type, false) . ' en Solicitudes de Procesos ( código:' . strip_tags($param->code) . ' )');

        $param->is_active = $request->is_active ? true : false;
        $param->updated_by = session()->get('user');

        $param->save();

        return redirect(route('process.request.index'))
            ->with('success', 'El ' . get_proreq_param($type, false) . ' fue modificado correctamente.');
    }
}
