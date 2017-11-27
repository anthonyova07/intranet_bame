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
        $view = view('human_resources.employee.param.create');

        if (in_array($type, ['POS'])) {
            $view->with('departments', Param::dep()->get());
            $view->with('levels', Param::lev()->get());
        }

        return $view->with('type', $type);
    }

    public function store(ParamRequest $request, $type)
    {
        $param = new Param;

        $param->id = uniqid(true);

        $param->type = $type;
        $param->name = $request->name;
        $param->level = $request->level;
        $param->dep_id = $request->department;

        $param->created_by = session()->get('user');

        $param->save();

        do_log('Creó el ' . get_employee_params($type) . ' de Empleados ( nombre:' . $param->name . ' )');

        return redirect()->route('human_resources.employee.index')->with('success', 'El ' . get_employee_params($type) . ' fue creado correctamente.');

    }

    public function edit($type, $param)
    {
        $param = Param::where('type', $type)->find($param);

        if (!$param) {
            return back()->with('warning', 'Este empleado no existe!');
        }

        $view = view('human_resources.employee.param.edit');

        if (in_array($type, ['POS'])) {
            $view->with('departments', Param::dep()->get());
            $view->with('levels', Param::lev()->get());
        }

        return $view->with('type', $type)->with('param', $param);
    }

    public function update(ParamRequest $request, $type, $param)
    {
        $param = Param::where('type', $type)->find($param);

        $param->type = $type;
        $param->name = $request->name;

        if (in_array($type, ['POS'])) {
            $param->level_id = $request->level;
        }

        if (in_array($type, ['LEVPOS'])) {
            $param->level = $request->level;
        }

        $param->dep_id = $request->department;

        $param->updated_by = session()->get('user');

        $param->save();

        do_log('Editó el ' . get_employee_params($type) . ' de Empleados ( nombre:' . $param->name . ' )');

        return redirect()->route('human_resources.employee.index')->with('success', 'El ' . get_employee_params($type) . ' fue creado correctamente.');
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

                if ($type == 'LEVPOS') {
                    if (isset($parts[0]) && !empty($parts[0])) {
                        $param = [];

                        $param['id'] = uniqid(true) . rand(0, 9);
                        $param['type'] = $type;
                        $param['name'] = utf8_encode(trim($parts[0]));
                        $param['level'] = is_int((int) trim($parts[1])) ? trim($parts[1]) : 0;
                        $param['created_by'] = session()->get('user');
                        $param['created_at'] = $time;
                        $param['updated_at'] = $time;

                        $params->push($param);
                    }

                    continue;
                }

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
