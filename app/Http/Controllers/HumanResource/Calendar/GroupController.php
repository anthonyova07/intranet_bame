<?php

namespace Bame\Http\Controllers\HumanResource\Calendar;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Calendar\Group;

class GroupController extends Controller
{
    public function create(Request $request)
    {
        return view('human_resources.calendar.group.create');
    }

    public function store(Request $request)
    {
        $group = new Group;

        $group->id = uniqid(true);
        $group->name = $request->name;
        $group->color = $request->color;
        $group->backcolor = $request->backcolor;
        $group->bordcolor = $request->bordcolor;
        $group->textcolor = $request->textcolor;
        $group->is_active = $request->is_active ? true : false;
        $group->created_at = session()->get('user');

        $gropu->save();
    }
}
