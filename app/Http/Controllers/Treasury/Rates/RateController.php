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

    public function create()
    {
        $products = Product::activeOnly()->get();
        // dd($products->get(2)->ranges());
        return view('treasury.rates.create')
            ->with('products', $products);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
