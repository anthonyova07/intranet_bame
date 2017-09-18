<?php

namespace Bame\Http\Controllers\Marketing\Lottery;

use Bame\Http\Requests;
use Illuminate\Http\Request;
use Bame\Http\Controllers\Controller;
use Bame\Models\Marketing\Lottery\Ticket;
use Bame\Models\Marketing\Lottery\Customer;

class LotteryController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::all();
        $tickets = Ticket::all();
        // dd($customers, $tickets);
        return view('marketing.lottery.index', compact('customers', 'tickets'));
    }

    public function create(Request $request)
    {
        $tickets = Ticket::all();

        if (! $tickets->count()) {
            $customers = Customer::orderBy('codigoCliente')->get();
            $tickets_generates = collect();

            foreach ($customers as $customer) {
                $tickets_to_generates = collect(range(1, $customer->BoletosGeneradosTotal));

                foreach ($tickets_to_generates->chunk(1000) as $chunks) {
                    foreach ($chunks as $key => $value) {
                        $tickets_generates->push([
                            'codigoCliente' => $customer->codigoCliente,
                        ]);
                    }

                    Ticket::insert($tickets_generates->toArray());

                    $tickets_generates = collect();
                }
            }

            return back()->withSuccess('Los boletos fueron generados correctamente.');
        }

        return back()->withWarning('Ya fueron generados los boletos.');
    }
}
