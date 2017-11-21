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
            'startyear' => 'required|date_format:Y',
            'endyear' => 'required|date_format:Y'
        ], [
            'startyear.required' => 'El campo Año no corresponde con el formato de fecha yyyy.',
            'startyear.date_format' => 'El campo Año no corresponde con el formato de fecha yyyy.',
            'endyear.required' => 'El campo Año no corresponde con el formato de fecha yyyy.',
            'endyear.date_format' => 'El campo Año no corresponde con el formato de fecha yyyy.'
        ]);

        $vacations = collect();

        if (Vacation::exist($request->startyear, $request->endyear)->count() > 0) {
            return back()->with('error', 'Las vacaciones para año Desde: ' . $request->startyear . ' Hasta: ' . $request->endyear . ' ya han sido generadas.');
        }

        $employees = Employee::active()->get();

        foreach ($employees as $employee) {
            $vacation = new Vacation;

            $vacation->recordcard = $employee->recordcard;
            $vacation->startyear = $request->startyear;
            $vacation->endyear = $request->endyear;
            $vacation->remaining = $employee->getMaxDayTakeVac(0);

            $vacations->push($vacation);
        }

        Vacation::insert($vacations->toArray());

        do_log('Generó las vacaciones de Empleados ( desde:' . $request->startyear . ',desde:' . $request->endyear . ' )');

        return back()->with('success', 'El año desde: ' . $request->startyear . ' hasta: ' . $request->endyear . ' de vacaciones fue generado correctamente.');

    }
}
