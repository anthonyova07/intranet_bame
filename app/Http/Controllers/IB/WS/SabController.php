<?php

namespace Bame\Http\Controllers\IB\WS;

use Illuminate\Http\Request;

use Bame\Http\Controllers\Controller;

use Bame\Models\IB\WS\Sab;

class SabController extends Controller
{
    public function index(Request $request)
    {
        if ($request->account) {
            $sab = new Sab;

            $sab->validateAccount($request->account);

            if ($sab->err()) {
                session()->flash('error', $sab->getResponseDescription());
            } else {
                // dd($sab->toObject());
                session()->put('customer_ib_sab', $sab->toObject());
                return redirect(route('ib.ws.sab.index'));
            }
        }

        return view('ib.ws.sab');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1|max:9999999999999.99',
            'transaction_type' => 'required|in:' . sab_transaction_types()->keys()->implode(','),
            'payment_method' => 'required|in:' . sab_payment_methods()->keys()->implode(','),
            'comment' => 'max:80',
        ]);

        $sab = new Sab;

        $sab->postAccountTransaction(session()->get('customer_ib_sab')->account, $request->amount, $request->transaction_type, $request->payment_method, $request->comment);

        if ($sab->err()) {
            return back()->with('error', $sab->getResponseDescription());
        }

        return redirect(route('ib.ws.sab.index'))->with('success', $sab->getResponseDescription());
    }

    public function destroy($id)
    {
        session()->forget('customer_ib_sab');

        return redirect(route('ib.ws.sab.index'));
    }
}
