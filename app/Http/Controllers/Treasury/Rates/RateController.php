<?php

namespace Bame\Http\Controllers\Treasury\Rates;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Treasury\Rates\Product;
use Bame\Models\Treasury\Rates\DateHistory;
use Bame\Models\Treasury\Rates\ProductHistory;
use Bame\Models\Treasury\Rates\ProductDetailHistory;
use Bame\Models\Treasury\Rates\ProductDetailRangeHistory;

class RateController extends Controller {

    public function index(Request $request)
    {
        return view('treasury.rates.index')
            ->with('products', Product::all());
    }

    public function create()
    {
        $products = Product::activeOnly()->get();

        return view('treasury.rates.create')
            ->with('products', $products);
    }

    public function store(Request $request)
    {
        $user_info =  session()->get('user_info');

        $products = Product::activeOnly()->get();

        $date_h = new DateHistory;

        $date_h->id = uniqid(true);
        $date_h->effec_date = $request->effective_date;

        $date_h->created_by = session()->get('user');
        $date_h->createname = $user_info->getFirstName() . ' ' . $user_info->getLastName();

        foreach ($request->all() as $key => $value) {
            if ($key == '_token' || $key == 'effective_date') {
                continue;
            }

            $parts = self::parts($key);

            $product = $products->where('id', $parts[1])->first();

            $product_h = new ProductHistory;

            $product_h->id = uniqid(true);
            $product_h->date_id = $date_h->id;
            $product_h->name = $product->name;
            $product_h->rate_type = $product->rate_type;
            $product_h->content = $product->content;
            $product_h->ranges = $product->ranges;

            $product_detail_h = new ProductDetailHistory;

            $product_detail_h->id = uniqid(true);
            $product_detail_h->pro_id = $product_h->id;

            if ($parts[0] == 'U') {
                $product_detail_h->value = $value;
            }

            if ($parts[0] == 'V') {
                $detail = $product->details->where('id', $parts[2])->first();

                $product_detail_h->sequence = $detail->sequence;
                $product_detail_h->descrip = $detail->descrip;
                $product_detail_h->value = $value;
            }

            if ($parts[0] == 'R') {
                $detail = $product->details->where('id', $parts[2])->first();

                $product_detail_h->sequence = $detail->sequence;

                $product_detail_h->descrip = $detail->descrip;

                foreach ($product->ranges() as $index => $range) {
                    $product_detail_range_h = new ProductDetailRangeHistory;

                    $product_detail_range_h->id = uniqid(true);
                    $product_detail_range_h->detail_id = $product_detail_h->id;
                    $product_detail_range_h->value = $value;
                }

            }

            dd($date_h, $product_h, $product_detail_h);
        }
    }

    public function parts($name)
    {
        return explode('_', $name);
    }
}
