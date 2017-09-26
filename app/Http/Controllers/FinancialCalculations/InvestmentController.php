<?php

namespace Bame\Http\Controllers\FinancialCalculations;

use Illuminate\Http\Request;
use Bame\Http\Controllers\Controller;
use Bame\Models\Treasury\Rates\DateHistory;
use Bame\Models\FinancialCalculations\Param;
use Bame\Models\FinancialCalculations\Investment\Investment;

class InvestmentController extends Controller {

    public function index(Request $request) {
        $investment = null;

        if ($request->amount
            || $request->days
            || $request->interests) {

            $this->validateRequest($request);

            $investment = new Investment($request->amount, $request->days, $request->interests);
            $investment->calculate_interests();
        }

        // $param_loans = Param::loans()->get();
        $param_investments = DateHistory::last()
            ->first()
            ->products()
            ->passiveRates()
            ->whereIn('content', ['U', 'V'])
            ->with(['details'])
            ->get();
// dd($param_investments);
        return view('financial_calculations.investment.index')
            ->with('param_investments', $param_investments)
            ->with('investment', $investment);
    }

    public function validateRequest(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'days' => 'required|integer',
            'interests' => 'required|numeric',
        ], [
            'amount.*' => 'Debe indicar un monto y debe ser numérico',
            'days.*' => 'Debe indicar un plazo y debe ser un número entero',
            'interests.*' => 'Debe indicar un interés y debe ser numérico',
        ]);
    }
}
