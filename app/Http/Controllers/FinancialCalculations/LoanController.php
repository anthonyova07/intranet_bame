<?php

namespace Bame\Http\Controllers\FinancialCalculations;

use Illuminate\Http\Request;
use Bame\Http\Controllers\Controller;
use Bame\Models\Treasury\Rates\DateHistory;
use Bame\Models\FinancialCalculations\Param;
use Bame\Models\FinancialCalculations\Loan\Loan;

class LoanController extends Controller {

    public function index(Request $request) {
        $loan = null;

        if ($request->amount
            || $request->year
            || $request->month
            || $request->interests) {

            $this->validateRequest($request);

            $loan = new Loan($request->amount, $request->month, $request->interests, $request->extraordinary, $request->month_extraordinary, $request->start_date);
        }

        // $param_loans = Param::loans()->get();
        $param_loans = DateHistory::last()
            ->first()
            ->products()
            ->activeRates()
            ->whereIn('name', ['Tasas Préstamos RD$', 'Tasas Préstamos US$'])
            ->with(['details'])
            ->get();
// dd($param_loans);
        return view('financial_calculations.loan.index')
            ->with('param_loans', $param_loans)
            ->with('loan', $loan);
    }

    public function validateRequest(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'year' => 'required|integer',
            'month' => 'required|integer',
            'interests' => 'required|numeric',
            'extraordinary' => 'numeric',
            'month_extraordinary' => 'integer|max:12',
            'start_date' => 'date_format:Y-m-d',
        ], [
            'amount.*' => 'Debe indicar un monto y debe ser numérico',
            'year.*' => 'Debe indicar un plazo y debe ser un número entero',
            'month.*' => 'Debe indicar un plazo y debe ser un número entero',
            'interests.*' => 'Debe indicar un interés y debe ser numérico',
            'extraordinary.*' => 'El monto extraordinario debe ser numérico',
            'month_extraordinary.*' => 'El mes extraordinario debe ser del 1 al 12',
            'start_date.*' => 'Debe indicar la fecha de inicio',
        ]);
    }
}
