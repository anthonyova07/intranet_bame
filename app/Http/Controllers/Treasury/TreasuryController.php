<?php

namespace Bame\Http\Controllers\Treasury;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Treasury\Rates\DateHistory;

class TreasuryController extends Controller
{
    public function rates()
    {
        $date_history = DateHistory::last()->first();

        return view('home.treasury.rates')
            ->with('backoffice', false)
            ->with('date_history', $date_history);
    }

}
