<?php

namespace Bame\Http\Controllers\Process\ClosingCost;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\Process\ClosingCost\ClosingCost;
use Bame\Http\Requests\Process\ClosingCost\ClosingCostRequest;

class ClosingCostController extends Controller
{
    public function create()
    {
        $closing_cost = ClosingCost::first();

        return view('process.closing_cost.create', [
            'closing_cost' => $closing_cost,
        ]);
    }

    public function store(ClosingCostRequest $request)
    {
        if ($request->exists == 'si') {
            $closing_cost = ClosingCost::first();
            $closing_cost->updated_by = session()->get('user');
        } else {
            $closing_cost = new ClosingCost;
            $closing_cost->id = uniqid(true);
            $closing_cost->created_by = session()->get('user');
        }

        $closing_cost->closincost = $request->closing_cost;

        $closing_cost->save();

        return back()->with('success', 'Los datos han sido guardados correctamente.');
    }
}
