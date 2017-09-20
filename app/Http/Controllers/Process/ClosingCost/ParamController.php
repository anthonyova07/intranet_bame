<?php

namespace Bame\Http\Controllers\Process\ClosingCost;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Process\ClosingCost\Param;
use Bame\Http\Requests\Process\ClosingCost\ParamRequest;

class ParamController extends Controller
{
    public function create($type)
    {
        return view('process.closing_cost.param.create')
            ->with('type', $type);
    }

    public function store(ParamRequest $request, $type)
    {
        $param = new Param;

        $param->id = uniqid(true);
        $param->type = $type;
        $param->name = cap_str(htmlentities($request->name));
        $param->created_by = session()->get('user');
        $param->save();

        do_log('Creó el parametro ' . get_closing_cost_params($type) . ' en Gastos de Cierre de Procesos ( nombre:' . $param->name . ' )');

        return redirect(route('process.closing_cost.{type}.param.create', ['type' => $type]))
            ->with('success', 'El ' . get_closing_cost_params($type) . ' fue creado correctamente.');
    }

    public function edit($type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . get_closing_cost_params($type) . ' no existe!');
        }

        return view('process.closing_cost.param.edit')
            ->with('param', $param);
    }

    public function update(ParamRequest $request, $type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . get_closing_cost_params($type) . ' no existe!');
        }

        $param->name = cap_str(htmlentities($request->name));
        $param->updated_by = session()->get('user');

        $param->save();

        do_log('Modificó el parametro ' . get_closing_cost_params($type, false) . ' en Gastos de Cierre de Procesos ( nombre:' . $param->name . ' )');

        return redirect()->route('process.closing_cost.index')
                ->with('success', 'El ' . get_closing_cost_params($type, false) . ' fue modificado correctamente.');
    }
}
