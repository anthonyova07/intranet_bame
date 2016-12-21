<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Customer\Claim\Claim;
use Bame\Models\Customer\Claim\Form\Form;

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

    public function form(Request $request, $claim_id, $form_type, $form_id)
    {
        $form = Form::where('claim_id', $claim_id)->where('form_type', $form_type)->find($form_id);

        return view('customer.claim.print.form')
                ->with('datetime', new DateTime)
                ->with('form', $form);
    }
}
