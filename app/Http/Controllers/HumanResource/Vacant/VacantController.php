<?php

namespace Bame\Http\Controllers\HumanResource\Vacant;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Vacant\Vacant;
use Bame\Http\Requests\HumanResource\Vacant\VacantRequest;

class VacantController extends Controller
{
    public function index(Request $request)
    {
        $vacancies = Vacant::all();

        if ($request->term) {
            $vacancies->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->term . '%')
                    ->orWhere('title', 'like', '%' . cap_str($request->term) . '%')
                    ->orWhere('detail', 'like', '%' . $request->term . '%')
                    ->orWhere('detail', 'like', '%' . cap_str($request->term) . '%');
            });
        }

        if ($request->date_from) {
            $vacancies->where(function ($query) use ($request) {
                $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
            });
        }

        if ($request->date_to) {
            $vacancies->where(function ($query) use ($request) {
                $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
            });
        }

        $vacancies = $vacancies->paginate();

        return view('human_resources.vacant.index')
            ->with('vacancies', $vacancies);
    }

    public function create()
    {
        return view('human_resources.vacant.create');
    }

    public function store(VacantRequest $request)
    {
        $vacant = new Vacant;

        $vacant->id = uniqid(true);
        $vacant->title = clear_tag($request->title);
        $vacant->detail = clear_tag(nl2br($request->detail));
        $vacant->is_active = $request->is_active ? true : false;
        $vacant->created_by = session()->get('user');

        $vacant->save();

        do_log('Creó la Vacante ( titulo:' . strip_tags($request->title) . ' )');

        $noti = new Notification('global');
        $noti->create('Nueva Vacante Disponible', $vacant->title, route('home.human_resources.vacant', ['id' => $vacant->id]));
        $noti->save();

        return redirect(route('human_resources.vacant.index'))->with('success', 'La vacante fue creada correctamente.');
    }

    public function show($id)
    {
        $vacant = Vacant::find($id);

        if (!$vacant) {
            return redirect()->with('warning', 'Esta vacante no existe!');
        }

        dd('show');

        // $subscriptions = Subscription::where('event_id', $vacant->id)
        //                                 ->where('is_subscribe', '1')
        //                                 ->get();

        // $unsubscriptions = Subscription::where('event_id', $vacant->id)
        //                                 ->where('is_subscribe', '0')
        //                                 ->get();

        // $accompanist_subscriptions = SubscriptionAccompanist::with('accompanist')
        //                                 ->where('event_id', $vacant->id)
        //                                 ->where('is_subscribe', '1')
        //                                 ->get();

        // return view('human_resources.vacant.show')
        //     ->with('vacant', $vacant)
        //     ->with('subscriptions', $subscriptions)
        //     ->with('unsubscriptions', $unsubscriptions)
        //     ->with('accompanist_subscriptions', $accompanist_subscriptions);
    }

    public function edit($id)
    {
        $vacant = Vacant::find($id);

        if (!$vacant) {
            return back()->with('warning', 'Esta vacante no existe!');
        }

        return view('human_resources.vacant.edit')
            ->with('vacant', $vacant);
    }

    public function update(VacantRequest $request, $id)
    {
        $vacant = Vacant::find($id);

        if (!$vacant) {
            return back()->with('warning', 'Esta vacante no existe!');
        }

        $vacant->title = clear_tag($request->title);
        $vacant->detail = clear_tag(nl2br($request->detail));
        $vacant->is_active = $request->is_active ? true : false;
        $vacant->updated_by = session()->get('user');

        $vacant->save();

        do_log('Editó la vacante ( titulo:' . strip_tags($vacant->title) . ' )');

        return redirect(route('human_resources.vacant.index'))->with('success', 'La vacante ha sido modificado correctamente.');
    }

    public function destroy($id)
    {
        $vacant = Vacant::find($id);

        if (!$vacant) {
            return back()->with('warning', 'Esta vacante no existe!');
        }

        $vacant->delete();

        do_log('Eliminó la vacante ( titulo:' . strip_tags($vacant->title) . ' )');

        return back()->with('success', 'La vacante ha sido eliminado correctamente.');
    }
}
