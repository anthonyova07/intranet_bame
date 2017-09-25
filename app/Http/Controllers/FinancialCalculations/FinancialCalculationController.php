<?php

namespace Bame\Http\Controllers\FinancialCalculations;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\FinancialCalculations\Param;

class FinancialCalculationController extends Controller
{
    public function index(Request $request)
    {
        $param = Param::all();

        $loans = $param->where('type', 'PRE');
        $investments = $param->where('type', 'INV');

        return view('financial_calculations.index', [
            'loans' => $loans,
            'investments' => $investments,
        ]);
    }
}
