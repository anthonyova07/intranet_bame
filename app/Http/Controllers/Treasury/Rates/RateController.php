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
        $dates = DateHistory::orderBy('effec_date', 'desc');

        if ($request->date_from) {
            $dates->where(function ($query) use ($request) {
                // $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
                $query->where('effec_date', '>=', $request->date_from);
            });
        }

        if ($request->date_to) {
            $dates->where(function ($query) use ($request) {
                // $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
                $query->where('effec_date', '<=', $request->date_to);
            });
        }

        return view('treasury.rates.index')
            ->with('dates', $dates->paginate())
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
        $products_p = [];

        $user_info =  session()->get('user_info');

        $products = Product::activeOnly()->get();

        $date_h = new DateHistory;

        $date_h->id = uniqid(true);
        $date_h->effec_date = $request->effective_date;

        $date_h->created_by = session()->get('user');
        $date_h->createname = $user_info->getFirstName() . ' ' . $user_info->getLastName();

        $date_h->save();

        foreach ($request->all() as $key => $value) {
            if ($key == '_token' || $key == 'effective_date') {
                continue;
            }

            $parts = self::parts($key);

            if (!in_array($parts[1], $products_p)) {
                $product = $products->where('id', $parts[1])->first();

                $product_h = new ProductHistory;

                $product_h->id = uniqid(true);
                $product_h->date_id = $date_h->id;
                $product_h->name = $product->name;
                $product_h->rate_type = $product->rate_type;
                $product_h->content = $product->content;
                $product_h->ranges = $product->ranges;

                $product_h->save();

                array_push($products_p, $parts[1]);
            }

            $product_detail_h = new ProductDetailHistory;

            $product_detail_h->id = uniqid(true);
            $product_detail_h->pro_id = $product_h->id;

            if ($parts[0] == 'U') {
                $product_detail_h->value = $value;
            }

            if ($parts[0] == 'V' || $parts[0] == 'R') {
                $detail = $product->details->where('id', $parts[2])->first();

                $product_detail_h->sequence = $detail->sequence;
                $product_detail_h->descrip = $detail->descrip;
            }

            if ($parts[0] == 'V') {
                $product_detail_h->value = $value;
            }

            if ($parts[0] == 'R') {
                $ranges_h = collect();

                foreach ($product->ranges() as $index => $range) {
                    $product_detail_range_h = new ProductDetailRangeHistory;

                    $product_detail_range_h->id = uniqid(true) . $index;
                    $product_detail_range_h->detail_id = $product_detail_h->id;
                    $product_detail_range_h->value = $value[$index];

                    $ranges_h->push($product_detail_range_h);
                }

                $product_detail_h->ranges()->saveMany($ranges_h);
            }

            $product_detail_h->save();
        }
    }

    public function show($rates)
    {
        $date = DateHistory::find($rates);

        return view('home.treasury.rates')
            ->with('backoffice', true)
            ->with('date_history', $date);
    }

    public function parts($name)
    {
        return explode('_', $name);
    }
}
