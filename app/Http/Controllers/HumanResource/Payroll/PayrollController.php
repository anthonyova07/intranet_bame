<?php

namespace Bame\Http\Controllers\HumanResource\Payroll;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Auth;
use DateTime;
use Bame\Models\HumanResource\Employee\Employee;
use Bame\Models\HumanResource\Payroll\{Payroll, PayrollDetail};
use Bame\Models\Notification\Notification;

class PayrollController extends Controller
{
    public function create(Request $request)
    {
        return view('human_resources.payroll.create');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('payrolls')) {
            $verified = false;
            $exists = true;
            $payroll_date = '';
            $quantity_lines = 0;
            $quantity_employee = 0;

            $employees = Employee::where('is_active', true)->get();

            $content = file($request->payrolls->path());

            foreach ($content as $index => $line) {
                // if ($index == 0) {
                //     continue;
                // }

                $parts = explode(',', $line);

                $payroll_date = trim($parts[1]);

                if (!$verified) {
                    $exists = Payroll::exists($parts[1]);

                    if ($exists) {
                        break;
                    }

                    $verified = true;
                }

                if ($parts[0] == 'I') {
                    $employee = $employees->where('recordcard', trim($parts[5]))->first();

                    $payroll = new Payroll;

                    $payroll->id = uniqid(true);
                    $payroll->payroldate = $payroll_date;
                    $payroll->recordcard = trim($parts[5]);
                    $payroll->identifica = trim($parts[6]);

                    if ($employee) {
                        $payroll->name = $employee->full_name;
                        $payroll->position = $employee->position->name;
                        $payroll->department = $employee->department->name;

                        if (trim($employee->mail) == '') {
                            $payroll->mail = trim($parts[11]);
                        } else {
                            $payroll->mail = $employee->mail;
                        }

                        $payroll->useremp = trim(explode('@', $payroll->mail)[0]);

                    } else {
                        $payroll->name = trim(utf8_encode($parts[2]));
                        $payroll->position = trim(utf8_encode($parts[3]));
                        $payroll->department = trim(utf8_encode($parts[4]));
                        $payroll->mail = trim($parts[11]);
                        $payroll->useremp = trim(explode('@', $payroll->mail)[0]);
                    }

                    $payroll->created_by = session()->get('user');

                    $payroll->save();

                    $quantity_employee++;

                    if (trim($payroll->useremp)) {
                        $parts_date = explode('-', $payroll_date);

                        Notification::notify('Tu nómina ha sido procesada.', 'Su nómina ya ha sido procesada.', route('human_resources.payroll.my', [
                            'year' => $parts_date[0],
                             'month' => $parts_date[1],
                             'day' => $parts_date[2]
                        ]), $payroll->useremp);
                    }
                }

                $payroll_detail = new PayrollDetail;

                $payroll_detail->id = uniqid(true);
                $payroll_detail->payroll_id = $payroll->id;

                $payroll_detail->transdate = trim($parts[7]);
                $payroll_detail->code = trim($parts[8]);
                $payroll_detail->comment = trim(utf8_encode($parts[9]));
                $payroll_detail->amount = trim($parts[10]);

                $payroll_detail->save();

                $quantity_lines++;
            }

            do_log('Procesó la Nómina ( fecha:' . $payroll_date . ' cantidad_empleados:' . $quantity_employee . ' cantidad_registros:' . $quantity_lines . ' )');

            $msg = 'La nómina de fecha ' . $payroll_date;

            if ($exists) {
                $type = 'error';
                $msg .= ' ya ha sido procesada.';
            } else {
                $type = 'success';
                $msg .= ' ha sido procesada correctamente.';
            }

            $msg .= ' (Empleados Procesados: ' . $quantity_employee . ', Registros Procesados: ' . $quantity_lines . ')';

            return redirect(route('human_resources.payroll.create'))->with($type, $msg);
        } else {
            return redirect(route('human_resources.payroll.create'))->with('warning', 'No se ha suministrado ningún archivo para cargar.');
        }
    }

    public function getPayRoll(Request $request)
    {
        $payroll = null;
        $total_discharge = 0;
        $total_ingress = 0;

        if (!$request->authenticated) {
            $request->session()->flush();
            Auth::logout();

            return redirect(route('human_resources.payroll.my', array_merge($request->all(), ['authenticated' => 1])));
        }

        if ($request->year && $request->month && $request->day) {
            $payroll = Payroll::byActualUser()->date("{$request->year}-{$request->month}-{$request->day}")->first();

            if (!$payroll) {
                session()->flash('error', "No existe nómina registrada para la fecha {$request->day}/{$request->month}/{$request->year}. Favor contactar con RRHH.");
            } else {
                $last_detail = $payroll->details->pop();

                $payroll->details->each(function ($detail, $index) use (&$total_discharge, &$total_ingress) {
                    if ($detail->amount < 0) {
                        $total_discharge += $detail->amount;
                    } else {
                        $total_ingress += $detail->amount;
                    }
                });
            }
        }

        if ($request->print == '1') {
            return view('human_resources.payroll.print', compact('payroll', 'total_ingress', 'total_discharge', 'last_detail'))->with('datetime', datetime());
        } else {
            return view('human_resources.payroll.my', compact('payroll', 'total_ingress', 'total_discharge', 'last_detail'));
        }
    }
}
