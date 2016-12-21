<?php

namespace Bame\Http\Controllers\HumanResource\Calendar;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Calendar\Date;
use Bame\Http\Requests\HumanResource\Calendar\DateRequest;

class DateController extends Controller
{
    public function create(Request $request)
    {
        return view('human_resources.calendar.date.create');
    }

    public function store(DateRequest $request)
    {
        $date = new Date;

        $date->id = uniqid(true);
        $date->group_id = $request->group_id;
        $date->title = $request->title;
        $date->startdate = $request->startdate;
        $date->enddate = $request->enddate;
        $date->created_by = session()->get('user');

        $date->save();

        do_log('Creó la fecha de calendario ( titulo:' . strip_tags($request->title) . ' )');

        return redirect(route('human_resources.calendar.date.create'))->with('success', 'La fecha fue creada correctamente.');
    }

    public function edit($id)
    {
        $date = Date::find($id);

        if (!$date) {
            return back()->with('warning', 'Esta fecha no existe!');
        }

        return view('human_resources.calendar.date.edit')
            ->with('date', $date);
    }

    public function update(DateRequest $request, $id)
    {
        $date = Date::find($id);

        if (!$date) {
            return back()->with('warning', 'Esta fecha no existe!');
        }

        $date->group_id = $request->group_id;
        $date->title = $request->title;
        $date->startdate = $request->startdate;
        $date->enddate = $request->enddate;
        $date->updated_by = session()->get('user');

        $date->save();

        do_log('Editó la fecha de calendario ( titulo:' . strip_tags($request->title) . ' )');

        return redirect(route('human_resources.calendar.index'))->with('success', 'La fecha de calendario fue editado correctamente.');
    }
}
