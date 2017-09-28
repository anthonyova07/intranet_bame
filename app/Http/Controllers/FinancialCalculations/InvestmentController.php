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
            ->whereIn('content', ['R'])
            ->with(['details', 'details.ranges'])
            ->get();
// dd($param_investments);
        return view('financial_calculations.investment.index')
            ->with('param_investments', $param_investments)
            ->with('investment', $investment);
    }

    public function validateRequest(Request $request)
    {
        $min_max = Investment::min_max($request->range_field);

        $min = $min_max['min'];
        $max = $min_max['max'];

        $this->validate($request, [
            'amount' => 'required|numeric' . ($min ? ('|min:' . $min) : '') . ($max ? ('|max:' . $max) : ''),
            'days' => 'required|integer',
            'interests' => 'required|numeric',
        ], [
            'amount.*' => 'Debe indicar un monto, debe ser numérico y dentro del rango seleccionado.',
            'days.*' => 'Debe indicar un plazo y debe ser un número entero.',
            'interests.*' => 'Debe indicar un interés y debe ser numérico.',
        ]);
    }
}
