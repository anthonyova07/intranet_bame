<?php

namespace Bame\Http\Controllers\Marketing\Event;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Marketing\Event\Accompanist;
use Bame\Models\Marketing\Event\Subscription\Accompanist as AccompanistSubscription;
use Bame\Http\Requests\Marketing\Event\Accompanist\AccompanistRequest;

class AccompanistController extends Controller
{
    public function index(Request $request)
    {
        $accompanists = Accompanist::where('owner', session()->get('user'));

        $accompanist_subscriptions = AccompanistSubscription::where('owner', session()->get('user'))
                                                                ->where('event_id', $request->event)
                                                                ->where('is_subscribe', '1')
                                                                ->get();

        if ($request->term) {
            $accompanists->where(function ($query) use ($request) {
                $query->where('names', 'like', '%' . $request->term . '%')
                    ->orWhere('names', 'like', '%' . cap_str($request->term) . '%')
                    ->orWhere('last_names', 'like', '%' . $request->term . '%')
                    ->orWhere('last_names', 'like', '%' . cap_str($request->term) . '%')
                    ->orWhere('identification', 'like', '%' . $request->term . '%');
            });
        }

        $accompanists = $accompanists->paginate();

        return view('marketing.event.accompanist.index')
            ->with('accompanists', $accompanists)
            ->with('event_id', $request->event)
            ->with('accompanist_subscriptions', $accompanist_subscriptions);
    }

    public function create(Request $request)
    {
        return view('marketing.event.accompanist.create')
                ->with('event_id', $request->event);
    }

    public function store(AccompanistRequest $request)
    {
        $accompanist = new Accompanist;

        $accompanist->id = uniqid(true);
        $accompanist->owner = session()->get('user');
        $accompanist->names = cap_str($request->names);
        $accompanist->last_names = cap_str($request->last_names);
        $accompanist->identification_type = $request->identification_type;
        $accompanist->identification = $request->identification;
        $accompanist->relationship = $request->relationship;

        $accompanist->save();

        do_log('Creó el Invitado ( nombre:' . strip_tags($accompanist->names . ' ' . $accompanist->last_names) . ' identificacion:' . $accompanist->identification . ' )');

        return redirect(route('marketing.event.accompanist.index', ['event' => $request->event]))->with('success', 'Invitado creado correctamente.');
    }

    public function show($id)
    {
        return redirect(route('marketing.event.accompanist.index'));
    }

    public function edit(Request $request, $id)
    {
        $accompanist = Accompanist::where('owner', session()->get('user'))->find($id);

        if (!$accompanist) {
            return back()->with('warning', 'Este Invitado no existe!');
        }

        return view('marketing.event.accompanist.edit')
            ->with('accompanist', $accompanist)
            ->with('event_id', $request->event);
    }

    public function update(AccompanistRequest $request, $id)
    {
        $accompanist = Accompanist::where('owner', session()->get('user'))->find($id);

        if (!$accompanist) {
            return back()->with('warning', 'Este Invitado no existe!');
        }

        $accompanist->names = cap_str($request->names);
        $accompanist->last_names = cap_str($request->last_names);
        $accompanist->identification_type = $request->identification_type;
        $accompanist->identification = $request->identification;
        $accompanist->relationship = $request->relationship;

        $accompanist->save();

        do_log('Editó el Invitado ( nombre:' . strip_tags($accompanist->names . ' ' . $accompanist->last_names) . ' identificacion:' . $accompanist->identification . ' )');

        return redirect(route('marketing.event.accompanist.index', ['event' => $request->event]))->with('success', 'Invitado modificado correctamente.');
    }

    public function destroy($id)
    {
        // $accompanist = Accompanist::where('owner', session()->get('user'))->find($id);

        // if (!$accompanist) {
        //     return back()->with('warning', 'Este Invitado no existe!');
        // }

        // $accompanist->delete();

        // do_log('Eliminó el Invitado ( nombre:' . strip_tags($accompanist->names . ' ' . $accompanist->last_names) . ' identificacion:' . $accompanist->identification . ' )');

        // return redirect(route('marketing.event.accompanist.index'))->with('success', 'Invitado eliminado correctamente.');
    }
}
