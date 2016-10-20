<?php

namespace Bame\Http\Controllers\Marketing\Event;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\Marketing\Event\Event;
use Bame\Http\Requests\Marketing\Event\EventRequest;
use Bame\Models\Marketing\Event\Subscription\Subscription;
use Bame\Models\Marketing\Event\Subscription\Accompanist as SubscriptionAccompanist;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::where('created_by', session()->get('user'));

        if ($request->term) {
            $events->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->term . '%')
                    ->orWhere('title', 'like', '%' . cap_str($request->term) . '%')
                    ->orWhere('detail', 'like', '%' . $request->term . '%')
                    ->orWhere('detail', 'like', '%' . cap_str($request->term) . '%');
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
        $event->limit_accompanists = $request->limit_accompanists ? true : false;
        $event->is_active = $request->is_active ? true : false;
        $event->number_persons = $request->limit_persons ? $request->number_persons : 0;
        $event->number_accompanists = $request->limit_accompanists ? $request->number_accompanists : 0;
        $event->created_by = session()->get('user');

        $event->save();

        do_log('Creó el Evento ( titulo:' . strip_tags($request->title) . ' )');

        $noti = new Notification('global');
        $noti->create('Nuevo Evento', $event->title, route('home.event', ['id' => $event->id]));
        $noti->save();

        return redirect(route('marketing.event.index'))->with('success', 'El evento fue creado correctamente.');
    }

    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()->with('warning', 'Este evento no existe!');
        }

        $subscriptions = Subscription::where('event_id', $event->id)
                                        ->where('is_subscribe', '1')
                                        ->get();

        $unsubscriptions = Subscription::where('event_id', $event->id)
                                        ->where('is_subscribe', '0')
                                        ->get();

        $accompanist_subscriptions = SubscriptionAccompanist::with('accompanist')
                                        ->where('event_id', $event->id)
                                        ->where('is_subscribe', '1')
                                        ->get();

        return view('marketing.event.show')
            ->with('event', $event)
            ->with('subscriptions', $subscriptions)
            ->with('unsubscriptions', $unsubscriptions)
            ->with('accompanist_subscriptions', $accompanist_subscriptions);
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
        $event->limit_accompanists = $request->limit_accompanists ? true : false;
        $event->is_active = $request->is_active ? true : false;
        $event->number_persons = $request->limit_persons ? $request->number_persons : 0;
        $event->number_accompanists = $request->limit_accompanists ? $request->number_accompanists : 0;
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
