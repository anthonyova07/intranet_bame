<?php

namespace Bame\Http\Controllers\HumanResource\Calendar;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Calendar\Group;
use Bame\Models\HumanResource\Calendar\Date;
use Bame\Http\Requests\HumanResource\Calendar\DateRequest;

class DateController extends Controller
{
    public function create(Request $request)
    {
        $groups = Group::get();

        return view('human_resources.calendar.date.create')
            ->with('groups', $groups);
    }

    public function store(DateRequest $request)
    {
        $date = new Date;

        $date->id = uniqid(true);
        $date->group_id = $request->group_id;
        $date->title = $request->title;
        $date->startdate = new DateTime($request->startdate);
        $date->enddate = new DateTime($request->enddate);
        $date->created_by = session()->get('user');

        $date->save();

        do_log('Creó la fecha de calendario ( titulo:' . strip_tags($request->title) . ' )');

        return redirect(route('human_resources.calendar.date.create'))->with('success', 'La fecha fue creada correctamente.');
    }

    public function edit($id)
    {
        $date = Date::find($id);

        $groups = Group::get();

        if (!$date) {
            return back()->with('warning', 'Esta fecha no existe!');
        }

        return view('human_resources.calendar.date.edit')
            ->with('date', $date)
            ->with('groups', $groups);
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

    public function loadfile(Request $request)
    {
        if ($request->hasFile('date_file')) {
            $content = file($request->file('date_file')->path());

            $dates = collect();

            foreach ($content as $index => $line) {
                if ($index == 0) {
                    continue;
                }

                $parts = explode(',', $line);

                if (isset($parts[1]) && !empty($parts[1])) {
                    $date = [];

                    $date['id'] = uniqid(true) . $index;
                    $date['group_id'] = $request->group_id;
                    $date['title'] = utf8_encode($parts[0]);

                    $parts_date = explode('.', $parts[1]);
                    $date['startdate'] = str_pad('20' . $parts_date['2'], 2, '0', STR_PAD_LEFT) .'-'. str_pad($parts_date['1'], 2, '0', STR_PAD_LEFT) .'-'. str_pad($parts_date['0'], 2, '0', STR_PAD_LEFT);

                    $date['enddate'] = $date['startdate'];
                    $date['created_by'] = session()->get('user');

                    $dates->push($date);
                }
            }

            Date::insert($dates->toArray());

            do_log('Realizó una carga masiva de fechas');

            return back()->with('success', 'Los fechas fueron cargadas correctamente.');
        }
    }

    public function delete(Request $request, $id)
    {
        $date = Date::find($id);

        if (!$date) {
            return back()->with('warning', 'Esta fecha no existe!');
        }

        $date->delete();

        return back()->with('success', 'La fecha ha sido eliminada correctamente.');
    }
}
