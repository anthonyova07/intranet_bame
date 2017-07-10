<?php

namespace Bame\Http\Controllers\HumanResource\Payroll;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
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

            $content = file($request->payrolls->path());

            foreach ($content as $index => $line) {
                if ($index == 0) {
                    continue;
                }

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
                    $payroll = new Payroll;

                    $payroll->id = uniqid(true);
                    $payroll->payroldate = $payroll_date;
                    $payroll->useremp = trim(explode('@', $parts[11])[0]);
                    $payroll->recordcard = trim($parts[5]);
                    $payroll->identifica = trim($parts[6]);
                    $payroll->name = trim(utf8_encode($parts[2]));
                    $payroll->position = trim($parts[3]);
                    $payroll->department = trim($parts[4]);
                    $payroll->mail = trim($parts[11]);

                    $payroll->created_by = session()->get('user');

                    $payroll->save();

                    $quantity_employee++;

                    if (trim($payroll->useremp)) {
                        Notification::notify('Tu nómina ha sido procesada.', 'Su nómina ya ha sido procesada.', 'url', $payroll->useremp);
                    }
                }

                $payroll_detail = new PayrollDetail;

                $payroll_detail->id = uniqid(true);
                $payroll_detail->payroll_id = $payroll->id;

                $payroll_detail->transdate = trim($parts[7]);
                $payroll_detail->code = trim($parts[8]);
                $payroll_detail->comment = trim($parts[9]);
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
        }
    }

    public function getPayRoll(Request $request)
    {
        $payroll = null;
        $total_discharge = 0;
        $total_ingress = 0;

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

        return view('human_resources.payroll.my', compact('payroll', 'total_ingress', 'total_discharge', 'last_detail'));
    }
}
