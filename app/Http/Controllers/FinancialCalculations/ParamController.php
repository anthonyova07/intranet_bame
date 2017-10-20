<?php

namespace Bame\Http\Controllers\FinancialCalculations;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\FinancialCalculations\Param;
use Bame\Http\Requests\FinancialCalculations\ParamRequest;

class ParamController extends Controller
{
    public function create($type)
    {
        return view('financial_calculations.param.create')
            ->with('type', $type);
    }

    public function store(ParamRequest $request, $type)
    {
        $param = new Param;

        $param->id = uniqid(true);
        $param->type = $type;

        $param->name = $request->name;
        $param->rate = $request->rate;

        do_log('Creó el parametro ' . get_financial_calculation_params($type) . ' en Reclamaciones ( código:' . strip_tags($param->code) . ' )');

        $param->created_by = session()->get('user');

        $param->save();

        return redirect(route('financial_calculations.{type}.param.create', ['type' => $type]))
            ->with('success', 'La tasa de ' . get_financial_calculation_params($type) . ' fue creada correctamente.');
    }

    public function edit($type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Esta tasa de ' . get_financial_calculation_params($type) . ' no existe!');
        }

        return view('financial_calculations.param.edit')
            ->with('param', $param);
    }

    public function update(ParamRequest $request, $type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Esta tasa de ' . get_financial_calculation_params($type) . ' no existe!');
        }

        $param->name = $request->name;
        $param->rate = $request->rate;

        $param->updated_by = session()->get('user');

        $param->save();

        return redirect(route('financial_calculations.index'))
            ->with('success', 'La tasa de ' . get_financial_calculation_params($type) . ' fue modificada correctamente.');
    }
}
