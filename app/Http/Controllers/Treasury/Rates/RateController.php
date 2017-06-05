<?php

namespace Bame\Http\Controllers\Treasury\Rates;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Treasury\Rates\Product;

class RateController extends Controller {

    public function index(Request $request)
    {
        return view('treasury.rates.index')
            ->with('products', Product::all());
    }
}
