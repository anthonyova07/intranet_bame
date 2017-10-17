<?php

namespace Bame\Http\Controllers\HumanResource\Calendar;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Calendar\Calendar;

use Bame\Models\HumanResource\Calendar\Group;
use Bame\Models\HumanResource\Calendar\Birthdate;
use Bame\Models\HumanResource\Calendar\Date;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $groups = Group::get();
        $dates = Date::get();
        // $birthdates = Birthdate::getFile();

        return view('human_resources.calendar.index')
            ->with('groups', $groups)
            ->with('dates', $dates);
            // ->with('birthdates', $birthdates);
    }
}
