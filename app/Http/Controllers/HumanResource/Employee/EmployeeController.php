<?php

namespace Bame\Http\Controllers\HumanResource\Employee;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\HumanResource\Employee\Employee;
use Bame\Models\HumanResource\Employee\Param;
use Bame\Http\Requests\HumanResource\Employee\EmployeeRequest;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::orderBy('recordcard');

        $params = Param::get();
        //
        // if ($request->term) {
        //     $employees->where(function ($query) use ($request) {
        //         $query->where('title', 'like', '%' . $request->term . '%')
        //             ->where('detail', 'like', '%' . $request->term . '%');
        //     });
        // }
        //
        // if ($request->date_from) {
        //     $employees->where(function ($query) use ($request) {
        //         $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
        //     });
        // }
        //
        // if ($request->date_to) {
        //     $employees->where(function ($query) use ($request) {
        //         $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        //     });
        // }
        //
        $employees = $employees->paginate();

        return view('human_resources.employee.index')
            ->with('params', $params)
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
        $employee->is_active = $request->is_active ? true : false;

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
}
