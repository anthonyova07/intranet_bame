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

    public function destroy($id)
    {
        session()->forget('customer_ib_sab');

        return redirect(route('ib.ws.sab.index'));
    }
}
