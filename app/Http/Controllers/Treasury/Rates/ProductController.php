<?php

namespace Bame\Http\Controllers\Treasury\Rates;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Treasury\Rates\Product;
use Bame\Http\Requests\Treasury\Rates\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::find($request->product);

        return view('treasury.rates.product.index')
            ->with('product', $product);
    }

    public function create()
    {
        return view('treasury.rates.product.create');
    }

    public function store(ProductRequest $request)
    {
        $product = new Product;

        $product->id = uniqid(true);
        $product->name = $request->name;
        $product->rate_type = $request->rate_type;
        $product->content = $request->content;

        if ($request->content == 'R') {
            $product->ranges = $request->ranges;
        }

        $product->is_active = $request->is_active ? true : false;
        $product->created_by = session()->get('user');

        $product->save();

        do_log('Creó un Producto en Tasas Activas/Pasivas de Tesorería ( nombre:' . strip_tags($request->name) . ' )');

        return redirect(route('treasury.rates.product.create'))
            ->with('success', 'El producto fue creado correctamente.');
    }

    public function edit($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return back()->with('warning', 'Este producto no existe!');
        }

        return view('treasury.rates.product.edit')
            ->with('product', $product);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return back()->with('warning', 'Este producto no existe!');
        }

        $product->name = $request->name;
        $product->rate_type = $request->rate_type;
        $product->content = $request->content;

        if ($request->content == 'R') {
            $product->ranges = $request->ranges;
        }

        $product->is_active = $request->is_active ? true : false;
        $product->updated_by = session()->get('user');

        $product->save();

        do_log('Modificó un producto en en Tasas Activas/Pasivas de Tesorería ( nombre:' . strip_tags($product->name) . ' )');

        return redirect(route('treasury.rates.index'))
            ->with('success', 'El producto fue modificado correctamente.');
    }
}
