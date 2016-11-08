<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Models\Customer\Customer;
use Bame\Http\Controllers\Controller;
use Bame\Models\Customer\CtDc\CtDc;

class ClaimController extends Controller
{
    public function index()
    {
        $ct_dc = CtDc::all();

        $claim_types = $ct_dc->where('type', 'CT');
        $distribution_channels = $ct_dc->where('type', 'DC');

        return view('customer.claim.index')
            ->with('claim_types', $claim_types)
            ->with('distribution_channels', $distribution_channels);
    }

    public function create(Request $request)
    {
        $ct_dc = CtDc::where('is_active', true)->get();

        $claim_types = $ct_dc->where('type', 'CT');
        $distribution_channels = $ct_dc->where('type', 'DC');

        $view = view('customer.claim.create');

        if ($request->identification) {

            $this->validate($request, [
                'identification' => 'required|max:15',
            ]);

            $identification = $request->identification;

            $customer = Customer::where('cusidn', $identification)->orWhere('cusln3', $identification)->first();

            if (!$customer) {
                return redirect(route('customer.claim.create'))->with('warning', 'La información suministrada no corresponde a ningún cliente en IBS.');
            }

            $customer->is_legal = $request->is_legal ? true : false;

            session()->put('customer_claim', $customer);
        }

        return $view
            ->with('claim_types', $claim_types)
            ->with('distribution_channels', $distribution_channels);
    }
}
