<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Customer\Claim\Claim;

class PrintController extends Controller
{
    public function claim(Request $request, $id)
    {
        $claim = Claim::find($id);

        if (!$claim->is_signed) {
            $claim->is_signed = true;
            $claim->save();
        }

        return view('customer.claim.print.claim')
            ->with('datetime', new DateTime)
            ->with('claim', $claim);
    }
}
