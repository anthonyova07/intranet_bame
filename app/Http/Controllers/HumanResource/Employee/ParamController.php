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
        $departments = Param::where('type', 'DEP')->get();

        return view('human_resources.employee.param.create')
            ->with('departments', $departments)
            ->with('type', $type);
    }

    public function store(ParamRequest $request, $type)
    {
        $param = new Param;

        $param->id = uniqid(true);

        $param->type = $type;
        $param->name = $request->name;
        $param->dep_id = $request->department;

        $param->created_by = session()->get('user');

        $param->save();

        do_log('Creó el ' . get_employee_params($type) . ' de Empleados ( nombre:' . $param->name . ' )');

        return redirect(route('human_resources.employee.index'))->with('success', 'El ' . get_employee_params($type) . ' fue creado correctamente.');

    }

    public function edit($type, $param)
    {
        $departments = Param::where('type', 'DEP')->get();
        $param = Param::where('type', $type)->find($param);

        if (!$param) {
            return back()->with('warning', 'Este empleado no existe!');
        }

        return view('human_resources.employee.param.edit')
            ->with('type', $type)
            ->with('departments', $departments)
            ->with('param', $param);
    }

    public function update(ParamRequest $request, $type, $param)
    {
        $param = Param::where('type', $type)->find($param);

        $param->type = $type;
        $param->name = $request->name;
        $param->dep_id = $request->department;

        $param->updated_by = session()->get('user');

        $param->save();

        do_log('Editó el ' . get_employee_params($type) . ' de Empleados ( nombre:' . $param->name . ' )');

        return redirect(route('human_resources.employee.index'))->with('success', 'El ' . get_employee_params($type) . ' fue creado correctamente.');
    }

    public function loadparams(Request $request, $type)
    {
        if ($request->hasFile('params')) {
            $content = file($request->file('params')->path());

            $params = collect();
            $time = (new DateTime)->format('Y-m-d H:i:s');

            foreach ($content as $index => $line) {
                if ($index == 0) {
                    continue;
                }

                $parts = explode(',', $line);

                if (isset($parts[1]) && !empty($parts[1])) {
                    $param = [];

                    $param['id'] = trim($parts[0]);
                    $param['type'] = $type;
                    $param['name'] = utf8_encode(trim($parts[1]));
                    $param['dep_id'] = isset($parts[2]) ? trim($parts[2]) : null;
                    $param['created_by'] = session()->get('user');
                    $param['created_at'] = $time;
                    $param['updated_at'] = $time;

                    $params->push($param);
                }
            }

            Param::insert($params->toArray());

            do_log('Realizó una carga masiva de ' . get_employee_params($type) . ' de empleados');

            return back()->with('success', 'Los ' . get_employee_params($type) . ' fueron cargadas correctamente.');
        } else {
            return back()->with('warning', 'No se ha indicado ningún archivo.');
        }
    }
}
