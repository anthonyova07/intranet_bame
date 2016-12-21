<?php

namespace Bame\Http\Controllers\HumanResource\Calendar;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Calendar\Calendar;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        return view('human_resources.calendar.index');
    }
}
