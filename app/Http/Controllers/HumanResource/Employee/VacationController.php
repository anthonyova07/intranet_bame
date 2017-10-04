<?php

namespace Bame\Http\Controllers\HumanResource\Employee;

use Bame\Http\Requests;
use Illuminate\Http\Request;
use Bame\Http\Controllers\Controller;
use Bame\Models\HumanResource\Employee\Employee;
use Bame\Models\HumanResource\Employee\Vacation;

class VacationController extends Controller
{
    public function create()
    {
        return view('human_resources.employee.vacation.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'year' => 'required|date_format:Y'
        ], [
            'year.date_format' => 'El campo Año no corresponde con el formato de fecha yyyy.'
        ]);

        $vacations = collect();

        $year = $request->year ? $request->year : datetime()->format('Y');

        if (Vacation::exist($year)->count() > 0) {
            return back()->with('error', 'Las vacaciones para año ' . $year . ' ya han sido generadas.');
        }

        $employees = Employee::active()->get();

        foreach ($employees as $employee) {
            $vacation = new Vacation;

            $vacation->recordcard = $employee->recordcard;
            $vacation->year = $year;
            $vacation->remaining = $employee->getMaxDayTakeVac(0);

            $vacations->push($vacation);
        }

        Vacation::insert($vacations->toArray());

        do_log('Generó las vacaciones de Empleados ( year:' . $year . ' )');

        return back()->with('success', 'El año ' . $year . ' fue generado correctamente.');

    }
}
