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
                    $payroll->useremp = trim(explode('@', $parts[12])[0]);
                    $payroll->recordcard = trim($parts[5]);
                    $payroll->identifica = trim($parts[6]);
                    $payroll->name = trim(utf8_encode($parts[2]));
                    $payroll->position = trim($parts[3]);
                    $payroll->department = trim($parts[4]);
                    $payroll->mail = trim($parts[12]);

                    $payroll->created_by = session()->get('user');

                    $payroll->save();

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
            }

            do_log('Procesó la Nómina ( fecha:' . $payroll_date . ' )');

            $msg = 'La nómina de fecha ' . $payroll_date;

            if ($exists) {
                $type = 'error';
                $msg .= ' ya ha sido procesada.';
            } else {
                $type = 'success';
                $msg .= ' ha sido procesada correctamente.';
            }

            return redirect(route('human_resources.payroll.create'))->with($type, $msg);
        }
    }

    public function getPayRoll(Request $request)
    {
        $payroll = null;

        $dates = Payroll::byActualUser()->get();

        if ($request->payroll_date) {
            $payroll = Payroll::date($request->payroll_date)->first();
        } else {
            if ($dates->count()) {
                $payroll = Payroll::date($dates->first()->payroldate)->first();
            }
        }

        return view('human_resources.payroll.my', compact('dates', 'payroll'));
    }
}
