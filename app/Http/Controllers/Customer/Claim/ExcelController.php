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

        $claims = $claims->get();
        // dd($claims);
        return view('customer.claim.excel.claim')
            ->with('claims', $claims);
    }
}
