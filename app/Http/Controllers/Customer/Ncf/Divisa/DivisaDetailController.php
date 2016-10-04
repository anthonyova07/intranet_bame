<?php

namespace Bame\Http\Controllers\Customer\Ncf\Divisa;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Http\Requests\Customer\Ncf\Divisa\Detail\EditRequest;

class DivisaDetailController extends Controller
{
    public function edit($id)
    {
        $transactions = collect(session()->get('transactions_divisa'));

        $transaction = $transactions->get($id);

        if (!$transaction) {
            return back()->with('warning', 'Esta transacción no existe!');
        }

        return view('customer.ncf.divisa.detail.edit')
        ->with('index', $id)
        ->with('transaction', $transaction);
    }

    public function update(EditRequest $request, $id)
    {
        $transactions = collect(session()->get('transactions_divisa'));

        $transaction = $transactions->get($id);

        if (!$transaction) {
            return back()->with('warning', 'Esta transacción no existe!');
        }

        $transaction->description = cap_str($request->description);

        $transactions->put($id, $transaction);

        session()->put('transactions_divisa', $transactions);

        return redirect(route('customer.ncf.divisa.new.index'))->with('success', 'El detalle ha sido editado con exito.');
    }

    public function destroy($id)
    {
        $transactions = collect(session()->get('transactions_divisa'));

        $transaction = $transactions->get($id);

        if (!$transaction) {
            return back()->with('warning', 'Esta transacción no existe!');
        }

        $transactions = $transactions->filter(function ($transaction, $index) use ($id) {
            if ($index == $id) {
                $customer = session()->get('customer_divisa');
                $customer->totalAmount -= ($transaction->getAmount() * $transaction->getRate());
            }

            return $index != $id;
        });

        session()->put('transactions_divisa', $transactions);

        return redirect(route('customer.ncf.divisa.new.index'))->with('success', 'El detalle ha sido eliminado con exito.');
    }
}
