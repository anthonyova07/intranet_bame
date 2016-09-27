<?php

namespace Bame\Http\Controllers\Operation\Tdc\Receipt;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Operation\Tdc\Receipt\TdcReceipt;
use Bame\Jobs\Operation\Tdc\Receipt\TdcReceiptGeneratorJob;
use Bame\Http\Requests\Operation\Tdc\Receipt\TdcReceiptRequest;

class TdcReceiptController extends Controller
{
    public function index()
    {
        $outstanding_amount = TdcReceipt::where('stsen_entr', '')->count();

        return view('operation.tdc.receipt.index')
        ->with('outstanding_amount', $outstanding_amount);
    }

    public function store(TdcReceiptRequest $request)
    {
        $log = 'Solicitó generar los encartes con (';

        $filters = collect();

        if ($request->identification) {
            $log .= ' identificación:' . $request->identification;
            $filters->put('identification', remove_dashes($request->identification));
        }

        if ($request->credit_card) {
            $log .= ' tarjeta:' . $request->credit_card;
            $filters->put('credit_card', remove_dashes($request->credit_card));
        }

        if ($request->date) {
            $log .= ' fecha:' . $request->date;
            $filters->put('date', remove_dashes($request->date));
        }

        if (!$request->identification and !$request->credit_card and !$request->date) {
            $log .= ' todos_los_pendientes';
            $filters->put('all_pending', true);
        }

        do_log($log .= ' )');

        $this->dispatch(new TdcReceiptGeneratorJob($filters, $request->session()->get('user')));

        return back()
            ->with('success', 'Los encartes solicitados serán generados en la ruta especificada.')
            ->with('info', 'El tiempo estimado dependerá de la cantidad de encartes (500 = 10 min aprox).');
    }
}
