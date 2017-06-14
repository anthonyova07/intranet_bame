<?php

namespace Bame\Http\Controllers\Treasury\Rates;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Treasury\Rates\Product;
use Bame\Models\Treasury\Rates\ProductDetail;
use Bame\Http\Requests\Treasury\Rates\ProductDetailRequest;

class ProductDetailController extends Controller
{
    public function create($product_id)
    {
        return view('treasury.rates.product.detail.create')
            ->with('product', Product::find($product_id));
    }

    public function store(ProductDetailRequest $request, $product_id)
    {
        $product_detail = new ProductDetail;

        $product_detail->id = uniqid(true);
        $product_detail->pro_id = $product_id;
        $product_detail->sequence = $request->sequence;
        $product_detail->descrip = $request->description;
        $product_detail->is_active = $request->is_active ? true : false;
        $product_detail->created_by = session()->get('user');

        $product_detail->save();

        do_log('Creó un Detalle del Producto en Tasas Activas/Pasivas de Tesorería ( descripción:' . strip_tags($request->description) . ' )');

        return redirect(route('treasury.rates.product.{product}.detail.create', ['product' => $product_id]))
            ->with('success', 'El detalle fue creado correctamente.');
    }

    public function edit($product_id, $detail)
    {
        $product_detail = ProductDetail::find($detail);

        if (!$product_detail) {
            return back()->with('warning', 'Este producto no existe!');
        }

        return view('treasury.rates.product.detail.edit')
            ->with('product_detail', $product_detail);
    }

    public function update(ProductDetailRequest $request, $product_id, $id)
    {
        $product_detail = ProductDetail::find($id);

        if (!$product_detail) {
            return back()->with('warning', 'Este producto no existe!');
        }

        $product_detail->sequence = $request->sequence;
        $product_detail->descrip = $request->description;
        $product_detail->is_active = $request->is_active ? true : false;
        $product_detail->updated_by = session()->get('user');

        $product_detail->save();

        do_log('Modificó un Detalle del Producto en en Tasas Activas/Pasivas de Tesorería ( descripción:' . strip_tags($product_detail->descrip) . ' )');

        return redirect(route('treasury.rates.product.index', ['product' => $product_id]))
            ->with('success', 'El producto fue modificado correctamente.');
    }
}
