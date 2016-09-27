<?php

namespace Bame\Http\Controllers\Customer\Ncf\NoIbs;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Http\Requests\Customer\Ncf\NoIbs\Detail\CreateRequest;

class NoIbsDetailController extends Controller
{

    public function create()
    {
        return view('customer.ncf.no_ibs.detail.create');
    }

    public function store(CreateRequest $request)
    {
        $transaction = new \stdClass;

        $transaction->description = cap_str($request->description);
        $transaction->amount = floatval($request->amount);
        $transaction->tax_amount = $request->calculate_tax ? (floatval($request->amount) * 0.18) : 0;
        $transaction->day = $request->day;
        $transaction->month = $request->month;
        $transaction->year = $request->year;

        if (session()->has('transactions_no_ibs')) {
            $transactions = collect(session()->get('transactions_no_ibs'));
        } else {
            $transactions = collect();
        }

        $transactions->push($transaction);

        session()->put('transactions_no_ibs', $transactions);

        return back()->with('success', 'El detalle ha sido agregado con exito.');
    }

    public function edit($id)
    {
        $transactions = collect(session()->get('transactions_no_ibs'));

        $transaction = $transactions->get($id);

        if (!$transaction) {
            return back()->with('warning', 'Esta transacción no existe!');
        }

        return view('customer.ncf.no_ibs.detail.edit')
            ->with('index', $id)
            ->with('transaction', $transaction);
    }

    public function update(CreateRequest $request, $id)
    {
        $transactions = collect(session()->get('transactions_no_ibs'));

        $transaction = $transactions->get($id);

        if (!$transaction) {
            return back()->with('warning', 'Esta transacción no existe!');
        }

        $transaction = new \stdClass;

        $transaction->description = cap_str($request->description);
        $transaction->amount = floatval($request->amount);
        $transaction->tax_amount = $request->calculate_tax ? (floatval($request->amount) * 0.18) : 0;
        $transaction->day = $request->day;
        $transaction->month = $request->month;
        $transaction->year = $request->year;

        $transactions->put($id, $transaction);

        session()->put('transactions_no_ibs', $transactions);

        return redirect(route('customer.ncf.no_ibs.new.index'))->with('success', 'El detalle ha sido editado con exito.');
    }

    public function destroy($id)
    {
        $transactions = collect(session()->get('transactions_no_ibs'));

        $transaction = $transactions->get($id);

        if (!$transaction) {
            return back()->with('warning', 'Esta transacción no existe!');
        }

        $transactions = $transactions->filter(function ($transaction, $index) use ($id) {
            return $index != $id;
        });

        session()->put('transactions_no_ibs', $transactions);

        return back()->with('success', 'El detalle ha sido eliminado con exito.');
    }
}
