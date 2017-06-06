<?php

namespace Bame\Http\Controllers\Treasury;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

class TreasuryController extends Controller
{
    public function rates()
    {
        return view('home.treasury.rates');
    }

}
