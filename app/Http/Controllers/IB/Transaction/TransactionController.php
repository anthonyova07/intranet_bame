<?php

namespace Bame\Http\Controllers\IB\Transaction;

use Illuminate\Http\Request;

use DateTime;
use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\IB\Transaction\Transaction;
use Bame\Models\IB\Transaction\TransactionType;
use Bame\Models\IB\Transaction\TransactionTypeCurrency;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::orderBy('transactionDate', 'desc')->where('transactionStatusID', 9001);

        if ($request->has('transaction_type')) {

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
        }

        if ($request->has('print')) {
            $datetime = new DateTime;
            $transaction_type = TransactionType::find($request->transaction_type);
            $transactions = $transactions->get();
            $view = view('pdfs.ib.transactions')
                ->with('transaction_type', $transaction_type)
                ->with('datetime', $datetime);
        } else {
            $transactions = $transactions->paginate();
            $transaction_types = TransactionType::where('longName', 'like', '%ACH%')->orderBy('longName')->get();
            $view = view('ib.transaction.index')
                ->with('transaction_types', $transaction_types);
        }

        return $view->with('transactions', $transactions);
    }
}
