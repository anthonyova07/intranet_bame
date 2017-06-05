<?php

namespace Bame\Http\Controllers\Treasury\Rates;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Treasury\Rates\ProductDetail;
use Bame\Http\Requests\Treasury\Rates\ProductDetailRequest;

class ProductDetailDetailController extends Controller
{
    public function create($product_id)
    {
        return view('treasury.rates.product.create');
    }

    public function store(ProductDetailRequest $request, $product_id)
    {
        $product = new ProductDetail;

        $product->id = uniqid(true);
        $product->name = $request->name;
        $product->rate_type = $request->rate_type;
        $product->content = $request->content;
        $product->is_active = $request->is_active ? true : false;
        $product->created_by = session()->get('user');

        $product->save();

        do_log('Creó el ProductDetailo ' . $request->name . ' en Tasas Activas/Pasivas de Tesorería ( nombre:' . strip_tags($request->name) . ' )');

        return redirect(route('treasury.rates.product.create'))
            ->with('success', 'El producto fue creado correctamente.');
    }

    public function edit($product_id, $id)
    {
        $product = ProductDetail::find($id);

        if (!$product) {
            return back()->with('warning', 'Este producto no existe!');
        }

        return view('treasury.rates.product.edit')
            ->with('product', $product);
    }

    public function update(ProductDetailRequest $request, $id)
    {
        $product = ProductDetail::find($id);

        if (!$product) {
            return back()->with('warning', 'Este producto no existe!');
        }

        $product->name = $request->name;
        $product->rate_type = $request->rate_type;
        $product->content = $request->content;
        $product->is_active = $request->is_active ? true : false;
        $product->updated_by = session()->get('user');

        $product->save();

        do_log('Modificó el producto ' . $request->name . ' en en Tasas Activas/Pasivas de Tesorería ( nombre:' . strip_tags($product->name) . ' )');

        return redirect(route('treasury.rates.index'))
            ->with('success', 'El producto fue modificado correctamente.');
    }
}
