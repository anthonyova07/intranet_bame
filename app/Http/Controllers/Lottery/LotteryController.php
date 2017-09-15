<?php

namespace Bame\Http\Controllers\Lottery;

use Bame\Http\Requests;
use Illuminate\Http\Request;
use Bame\Models\BI\Lottery\Ticket;
use Bame\Models\BI\Lottery\Customer;
use Bame\Http\Controllers\Controller;

class LotteryController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::all();
        $tickets = Ticket::all();
        // dd($customers, $tickets);
        return view('lottery.index', compact('customers', 'tickets'));
    }
}
