<?php

namespace Bame\Http\Controllers\HumanResource\Calendar;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Calendar\Group;
use Bame\Http\Requests\HumanResource\Calendar\GroupRequest;

class GroupController extends Controller
{
    public function create(Request $request)
    {
        return view('human_resources.calendar.group.create');
    }

    public function store(GroupRequest $request)
    {
        $group = new Group;

        $group->id = uniqid(true);
        $group->name = $request->name;
        // $group->color = $request->color;
        $group->backcolor = $request->backcolor;
        $group->bordcolor = $request->bordcolor;
        $group->textcolor = $request->textcolor;
        $group->is_active = $request->is_active ? true : false;
        $group->created_by = session()->get('user');

        $group->save();

        do_log('Creó el grupo de calendario ( nombre:' . strip_tags($request->name) . ' )');

        return redirect(route('human_resources.calendar.group.create'))->with('success', 'El grupo de calendario fue creado correctamente.');
    }

    public function edit($id)
    {
        $group = Group::find($id);

        if (!$group) {
            return back()->with('warning', 'Este grupo no existe!');
        }

        return view('human_resources.calendar.group.edit')
            ->with('group', $group);
    }

    public function update(GroupRequest $request, $id)
    {
        $group = Group::find($id);

        if (!$group) {
            return back()->with('warning', 'Este grupo no existe!');
        }

        $group->name = $request->name;
        // $group->color = $request->color;
        $group->backcolor = $request->backcolor;
        $group->bordcolor = $request->bordcolor;
        $group->textcolor = $request->textcolor;
        $group->is_active = $request->is_active ? true : false;
        $group->updated_by = session()->get('user');

        $group->save();

        do_log('Editó el grupo de calendario ( nombre:' . strip_tags($request->name) . ' )');

        return redirect(route('human_resources.calendar.index'))->with('success', 'El grupo de calendario fue editado correctamente.');
    }
}
