<?php

namespace Bame\Http\Controllers\IB\Transaction;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\IB\Transaction\Transaction;
use Bame\Models\IB\Transaction\TransactionType;
use Bame\Models\IB\Transaction\TransactionTypeCurrency;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transaction_types = TransactionType::orderBy('longName')->get();

        $transactions = collect();

        if ($request->has('transaction_type')) {
            $transactions = Transaction::orderBy('transactionDate', 'desc');

            if ($request->has('date_from')) {
                $date_parts = explode('T', $request->date_from);

                $transactions = $transactions->where('transactionDate', '>=', $date_parts[0] . ' ' . $date_parts[1]);
            }

            if ($request->has('date_to')) {
                $date_parts = explode('T', $request->date_to);

                $transactions = $transactions->where('transactionDate', '<=', $date_parts[0] . ' ' . $date_parts[1]);
            }

            $transactions_types_currency_origin = $transactions->pluck('trnTypeCurrencyID')->unique();

            $transactions_types_currency_destiny = TransactionTypeCurrency::whereIn('trnTypeCurrencyID', $transactions_types_currency_origin->toArray())
                                    ->where('transactionTypeID', $request->transaction_type)
                                    ->pluck('trnTypeCurrencyID');

            $transactions = $transactions->whereIn('trnTypeCurrencyID', $transactions_types_currency_destiny->toArray());

            $transactions = $transactions->paginate();
        }

        return view('ib.transaction.index')
            ->with('transaction_types', $transaction_types)
            ->with('transactions', $transactions);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
