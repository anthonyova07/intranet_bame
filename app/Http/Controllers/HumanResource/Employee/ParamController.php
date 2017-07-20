<?php

namespace Bame\Http\Controllers\HumanResource\Employee;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\HumanResource\Employee\Param;
use Bame\Http\Requests\HumanResource\Employee\ParamRequest;

class ParamController extends Controller
{
    public function create($type)
    {
        return view('human_resources.employee.param.create')
            ->with('type', $type);
    }

    public function store(ParamRequest $request, $type)
    {
        $param = new Param;

        $param->id = uniqid(true);

        $param->type = $type;
        $param->name = $request->name;

        $param->created_by = session()->get('user');

        $param->save();

        do_log('Creó el ' . get_employee_params($type) . ' de Empleados ( nombre:' . $param->name . ' )');

        return redirect(route('human_resources.employee.index'))->with('success', 'El ' . get_employee_params($type) . ' fue creado correctamente.');

    }

    public function edit($type, $param)
    {
        $param = Param::where('type', $type)->find($param);

        if (!$param) {
            return back()->with('warning', 'Este empleado no existe!');
        }

        return view('human_resources.employee.param.edit')
            ->with('type', $type)
            ->with('param', $param);
    }

    public function update(ParamRequest $request, $type, $param)
    {
        $param = Param::where('type', $type)->find($param);

        $param->type = $type;
        $param->name = $request->name;

        $param->updated_by = session()->get('user');

        $param->save();

        do_log('Editó el ' . get_employee_params($type) . ' de Empleados ( nombre:' . $param->name . ' )');

        return redirect(route('human_resources.employee.index'))->with('success', 'El ' . get_employee_params($type) . ' fue creado correctamente.');
    }
}
