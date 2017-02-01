<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Customer\Claim\Claim;
use Bame\Models\Customer\Claim\Form\Form;

class ExcelController extends Controller
{
    public function claim(Request $request)
    {
        $claims = Claim::orderBy('created_at', 'asc');

        if ($request->date_from) {
            $claims->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $claims->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        do_log('Exportó a Excel las Reclamaciones ( desde:' . strip_tags($request->date_from) . ' hasta:' . strip_tags($request->date_to) . ' )');

        if ($request->claim_result) {
            $claims = $claims->where('claim_result', $request->claim_result)->get();

            return view('customer.claim.excel.daily')
                ->with('claims', $claims);
        } else {
            $claims = $claims->get();

            return view('customer.claim.excel.claim')
                ->with('claims', $claims);
        }
    }
}
