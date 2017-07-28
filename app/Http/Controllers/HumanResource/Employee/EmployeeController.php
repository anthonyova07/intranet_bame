<?php

namespace Bame\Http\Controllers\HumanResource\Employee;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\HumanResource\Calendar\Birthdate;
use Bame\Models\HumanResource\Employee\Employee;
use Bame\Models\HumanResource\Employee\Param;
use Bame\Http\Requests\HumanResource\Employee\EmployeeRequest;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::orderBy('recordcard');

        $params = Param::get();

        if ($request->term) {
            $term = "%{$request->term}%";
            $employees->where(function ($query) use ($request, $term) {
                $query->where('recordcard', 'like', $term)
                    ->orWhere('name', 'like', $term)
                    ->orWhere('identifica', 'like', $term)
                    ->orWhere('useremp', 'like', $term)
                    ->orWhere('mail', 'like', $term);
            });
        }

        if ($request->status != '') {
            if (in_array($request->status, ['1', '0'])) {
                $employees->where('is_active', $request->status);
            }
        }

        if ($request->status == null) {
            $employees->where('is_active', true);
        }

        if ($request->date_from) {
            $employees->where('servicedat', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $employees->where('servicedat', '<=', $request->date_to);
        }

        $employees = $employees->paginate();

        $bulk_load = config('bame.employee.bulk_load');

        return view('human_resources.employee.index')
            ->with('params', $params)
            ->with('bulk_load', $bulk_load)
            ->with('employees', $employees);
    }

    public function create()
    {
        $employees = Employee::where('is_active', true)->get();
        $params = Param::get();

        return view('human_resources.employee.create')
            ->with('employees', $employees)
            ->with('params', $params);
    }

    public function store(EmployeeRequest $request)
    {
        $employee = new Employee;

        $employee->id = uniqid(true);
        $employee->recordcard = $request->recordcard;
        $employee->name = $request->name;
        $employee->identifica = $request->identification;
        $employee->useremp = explode('@', $request->mail)[0];
        $employee->mail = $request->mail;
        $employee->birthdate = $request->birthdate;
        $employee->servicedat = $request->servicedat;
        $employee->gender = $request->gender;
        $employee->is_active = true;

        $employee->id_pos = $request->position;
        $employee->id_dep = $request->department;
        $employee->id_sup = $request->supervisor;

        $employee->created_by = session()->get('user');

        $employee->save();

        do_log('Creó un Empleado ( código:' . $employee->recordcard . ', nombre:' . $employee->name . ', correo:' . $employee->mail . ' )');

        return redirect(route('human_resources.employee.index'))->with('success', ($employee->gender == 'f' ? 'La empleada fue creada ':'El empleado fue creado') . ' correctamente.');

    }

    public function show($id)
    {
        return redirect(route('human_resources.employee.index'));
    }

    public function edit($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return back()->with('warning', 'Este empleado no existe!');
        }

        $employees = Employee::where('is_active', true)->where('id', '<>', $employee->id)->get();
        $params = Param::get();

        return view('human_resources.employee.edit')
            ->with('employees', $employees)
            ->with('params', $params)
            ->with('employee', $employee);
    }

    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::find($id);

        $employee->recordcard = $request->recordcard;
        $employee->name = $request->name;
        $employee->identifica = $request->identification;
        $employee->useremp = explode('@', $request->mail)[0];
        $employee->mail = $request->mail;
        $employee->birthdate = $request->birthdate;
        $employee->servicedat = $request->servicedat;
        $employee->gender = $request->gender;
        $employee->is_active = $request->is_active ? true : false;

        $employee->id_pos = $request->position;
        $employee->id_dep = $request->department;
        $employee->id_sup = $request->supervisor;

        $employee->updated_by = session()->get('user');

        $employee->save();

        do_log('Editó un Empleado ( código:' . $employee->recordcard . ', nombre:' . $employee->name . ', correo:' . $employee->mail . ' )');

        return redirect(route('human_resources.employee.index'))->with('success', ($employee->gender == 'f' ? 'La empleada fue modificada ':'El empleado fue modificado') . ' correctamente.');
    }

    public function destroy($id)
    {
        return redirect(route('human_resources.employee.index'));
    }

    public function load(Request $request)
    {
        if ($request->hasFile('params')) {
            $content = file($request->file('params')->path());

            $emps = Birthdate::getFile();

            $employees = collect();
            $time = (new DateTime)->format('Y-m-d H:i:s');
            $year = (new DateTime)->format('Y');
            $date = (new DateTime)->format('Y-m-d');

            foreach ($content as $index => $line) {
                if ($index == 0) {
                    continue;
                }

                $parts = explode(',', $line);

                $emp = $emps->where('code', trim($parts[0]))->first();

                if (isset($parts[1]) && !empty($parts[1])) {
                    $employee = [];

                    $employee['id'] = uniqid(true) . $index;
                    $employee['recordcard'] = trim($parts[0]);
                    $employee['name'] = trim(utf8_encode($parts[1]));
                    $employee['identifica'] = trim($parts[2]);

                    $employee['useremp'] = trim($parts[5]) == '' ? '' : explode('@', $parts[5])[0];
                    $employee['mail'] = trim($parts[5]);

                    if ($emp) {
                        $employee['birthdate'] = ($emp->month_day == '00-00' ? $date : ($year . '-' . $emp->month_day));

                        $service_date_parts = explode('/', $emp->services_date);
                        $employee['servicedat'] = $service_date_parts[2] . '-' . $service_date_parts[1] . '-' . $service_date_parts[0];

                        $employee['gender'] = $emp->gender == 'Femenino' ? 'f' : 'm';
                    } else {
                        $employee['birthdate'] = $date;

                        $employee['servicedat'] = $date;

                        $employee['gender'] = '';
                    }

                    $employee['is_active'] = true;

                    $employee['id_pos'] = trim($parts[3]);
                    $employee['id_dep'] = trim($parts[4]);
                    $employee['id_sup'] = '';

                    $employee['created_by'] = session()->get('user');
                    $employee['created_at'] = $time;
                    $employee['updated_at'] = $time;

                    $employees->push($employee);
                }
            }

            Employee::insert($employees->toArray());

            do_log('Realizó una carga masiva de empleados');

            return back()->with('success', 'Los empleados fueron cargadas correctamente.');
        } else {
            return back()->with('warning', 'No se ha indicado ningún archivo.');
        }
    }

    public function export(Request $request)
    {
        if (!in_array($request->type, ['excel', 'pdf', 'employee'])) {
            return false;
        }

        if (in_array($request->type, ['excel', 'pdf'])) {
            $employees = Employee::orderBy('recordcard');

            if ($request->term) {
                $term = "%{$request->term}%";
                $employees->where(function ($query) use ($request, $term) {
                    $query->where('recordcard', 'like', $term)
                        ->orWhere('name', 'like', $term)
                        ->orWhere('identifica', 'like', $term)
                        ->orWhere('useremp', 'like', $term)
                        ->orWhere('mail', 'like', $term);
                });
            }

            if ($request->status != '') {
                if (in_array($request->status, ['1', '0'])) {
                    $employees->where('is_active', $request->status);
                }
            }

            if ($request->status == null) {
                $employees->where('is_active', true);
            }

            if ($request->date_from) {
                $employees->where('servicedat', '>=', $request->date_from);
            }

            if ($request->date_to) {
                $employees->where('servicedat', '<=', $request->date_to);
            }

            $employees = $employees->get();

            return view('human_resources.employee.export.' . $request->type)
                ->with('datetime', new DateTime)
                ->with('type', $request->type)
                ->with('status', $request->status)
                ->with('employees', $employees);
        }

        if ($request->type == 'employee') {
            $employee = Employee::find($request->id);

            return view('human_resources.employee.export.' . $request->type)
                ->with('datetime', new DateTime)
                ->with('employee', $employee);
        }
    }
}
