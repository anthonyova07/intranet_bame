<?php

namespace Bame\Http\Controllers\Operation\Tdc\Transaction;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Operation\Tdc\Description;
use Bame\Models\Operation\Tdc\Transaction\TransactionDays;

class TransactionDaysController extends Controller
{
    public function index(Request $request)
    {
        set_time_limit(600);

        if (!count($request->all())) {
            $descriptions = Description::where('prefi_desc', 'SAT_CODTR')->orWhere('prefi_desc', 'SAT_CONCEP')->get();

            return view('operation.tdc.transaction.days.index')
                ->with('descriptions', $descriptions)
                ->with('transactions', collect());
        }

        $transactions = TransactionDays::orderBy('fecpr_atrn')->where('ststr_atrn', 'A');

        if ($request->transaction_type) {
            $transactions->where('codtr_atrn', $request->transaction_type);
        }

        if ($request->concept) {
            $transactions->where('codco_atrn', $request->concept);
        }

        if ($request->currency) {
            $transactions->where('moned_atrn', $request->currency);
        }

        if ($request->date_from) {
            $transactions->where('fecpr_atrn', '>=', remove_dashes($request->date_from));
        }

        if ($request->date_to) {
            $transactions->where('fecpr_atrn', '<=', remove_dashes($request->date_to));
        }

        if ($request->format == 'excel') {
            $view = view('operation.tdc.transaction.days.excel.transactions');
            $transactions = $transactions->get();
        } else {
            $descriptions = Description::where('prefi_desc', 'SAT_CODTR')->orWhere('prefi_desc', 'SAT_CONCEP')->get();
            $transactions = $transactions->paginate();
            $view = view('operation.tdc.transaction.days.index')
                ->with('descriptions', $descriptions);
        }

        return $view->with('transactions', $transactions);
    }

}
