<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Customer\Claim\Claim;
use Bame\Models\Customer\Product\CreditCardStatement;

class ClaimFormController extends Controller
{
    public function consumption(Request $request, $id)
    {
        $claim = Claim::find($id);

        if (!$claim) {
            return redirect(route('customer.claim.index'))->with('warning', 'Esta reclamación no existe!');
        }

        // $creditcard_statements = CreditCardStatement::where('numta_dect', $claim->product_number)->get();

        // session()->put('tdc_transactions_claim', $creditcard_statements);

        return view('customer.claim.form.consumption')
                ->with('id', $id)
                ->with('claim', $claim);
    }

    public function storeConsumption(Request $request, $id)
    {
        dd($request->all());
    }
}
