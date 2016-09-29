<?php

namespace Bame\Http\Controllers\Marketing\Event;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Marketing\Event\Event;
use Bame\Http\Requests\Marketing\Event\EventRequest;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::where('created_by', session()->get('user'));

        if ($request->term) {
            $events->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->term . '%')
                    ->where('detail', 'like', '%' . $request->term . '%');
            });
        }

        if ($request->date_from) {
            $events->where(function ($query) use ($request) {
                $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
            });
        }

        if ($request->date_to) {
            $events->where(function ($query) use ($request) {
                $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
            });
        }

        $events = $events->paginate();

        return view('marketing.event.index')
            ->with('events', $events);
    }

    public function create()
    {
        return view('marketing.event.create');
    }

    public function store(EventRequest $request)
    {
        $event = new Event;

        $event->id = uniqid(true);
        $event->title = clear_tag($request->title);
        $event->detail = clear_tag(nl2br($request->detail));

        if ($request->hasFile('image')) {
            $file_name_destination = $event->id . '.' . get_extensions_file($request->file('image')->getClientOriginalName());

            $request->file('image')->move(public_path() . '\\marketing\\images\\', $file_name_destination);

            $event->image = '/marketing/images/' . $file_name_destination;
        }

        $event->end_subscriptions = new DateTime($request->end_subscriptions . ' 23:59:59');
        $event->start_event = new DateTime($request->start_event);
        $event->limit_persons = $request->limit_persons ? true : false;
        $event->is_active = $request->is_active ? true : false;
        $event->number_persons = $request->number_persons;
        $event->number_companions = $request->number_companions;
        $event->created_by = session()->get('user');

        $event->save();

        do_log('Creó el Evento ( titulo:' . strip_tags($request->title) . ' )');

        return redirect(route('marketing.event.index'))->with('success', 'El evento fue creado correctamente.');
    }

    public function show($id)
    {
        return redirect(route('marketing.event.index'));
    }

    public function edit($id)
    {
        $event = Event::where('created_by', session()->get('user'))->find($id);

        if (!$event) {
            return back()->with('warning', 'Este evento no existe!');
        }

        return view('marketing.event.edit')
            ->with('event', $event);
    }

    public function update(EventRequest $request, $id)
    {
        $event = Event::where('created_by', session()->get('user'))->find($id);

        if (!$event) {
            return back()->with('warning', 'Este evento no existe!');
        }

        $event->title = clear_tag($request->title);
        $event->detail = clear_tag(nl2br($request->detail));

        if ($request->hasFile('image')) {
            $file_name = public_path() . str_replace('/', '\\', $event->image);

            if (file_exists($file_name)) {
                unlink($file_name);
            }

            $file_name_destination = $id . '.' . get_extensions_file($request->file('image')->getClientOriginalName());

            $request->file('image')->move(public_path() . '\\marketing\\images\\', $file_name_destination);

            $event->image = '/marketing/images/' . $file_name_destination;
        }

        $event->end_subscriptions = new DateTime($request->end_subscriptions . ' 23:59:59');
        $event->start_event = new DateTime($request->start_event);
        $event->limit_persons = $request->limit_persons ? true : false;
        $event->is_active = $request->is_active ? true : false;
        $event->number_persons = $request->number_persons;
        $event->number_companions = $request->number_companions;
        $event->updated_by = session()->get('user');

        $event->save();

        do_log('Editó el Evento ( titulo:' . strip_tags($request->title) . ' )');

        return redirect(route('marketing.event.index'))->with('success', 'El evento ha sido modificado correctamente.');
    }

    public function destroy($id)
    {
        $event = Event::where('created_by', session()->get('user'))->find($id);

        if (!$event) {
            return back()->with('warning', 'Este evento no existe!');
        }

        $file_name = public_path() . str_replace('/', '\\', $event->image);

        if (file_exists($file_name)) {
            unlink($file_name);
        }

        $event->delete();

        do_log('Eliminó el Evento ( titulo:' . strip_tags($event->title) . ' )');

        return back()->with('success', 'El evento ha sido eliminado correctamente.');
    }
}