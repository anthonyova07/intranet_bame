<?php

namespace Bame\Http\Controllers\Marketing\Event;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Marketing\Event\Accompanist;
use Bame\Http\Requests\Marketing\Event\Accompanist\AccompanistRequest;

class AccompanistController extends Controller
{
    public function index(Request $request)
    {
        $accompanists = Accompanist::where('owner', session()->get('user'));

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
            ->with('accompanists', $accompanists);
    }

    public function create()
    {
        return view('marketing.event.accompanist.create');
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

        do_log('Creó el Acompañante ( nombre:' . strip_tags($accompanist->names . ' ' . $accompanist->last_names) . ' identificacion:' . $accompanist->identification . ' )');

        return redirect(route('marketing.event.accompanist.index'))->with('success', 'Acompañante creado correctamente.');
    }

    public function show($id)
    {
        return redirect(route('marketing.news.index'));
    }

    public function edit($id)
    {
        $accompanist = Accompanist::where('owner', session()->get('user'))->find($id);

        if (!$accompanist) {
            return back()->with('warning', 'Este acompañante no existe!');
        }

        return view('marketing.event.accompanist.edit')
            ->with('accompanist', $accompanist);
    }

    public function update(AccompanistRequest $request, $id)
    {
        $accompanist = Accompanist::where('owner', session()->get('user'))->find($id);

        if (!$accompanist) {
            return back()->with('warning', 'Este acompañante no existe!');
        }

        $accompanist->names = cap_str($request->names);
        $accompanist->last_names = cap_str($request->last_names);
        $accompanist->identification_type = $request->identification_type;
        $accompanist->identification = $request->identification;
        $accompanist->relationship = $request->relationship;

        $accompanist->save();

        do_log('Editó el Acompañante ( nombre:' . strip_tags($accompanist->names . ' ' . $accompanist->last_names) . ' identificacion:' . $accompanist->identification . ' )');

        return redirect(route('marketing.event.accompanist.index'))->with('success', 'Acompañante modificado correctamente.');
    }

    public function destroy($id)
    {
        // $accompanist = Accompanist::where('owner', session()->get('user'))->find($id);

        // if (!$accompanist) {
        //     return back()->with('warning', 'Este acompañante no existe!');
        // }

        // $accompanist->delete();

        // do_log('Eliminó el Acompañante ( nombre:' . strip_tags($accompanist->names . ' ' . $accompanist->last_names) . ' identificacion:' . $accompanist->identification . ' )');

        // return redirect(route('marketing.event.accompanist.index'))->with('success', 'Acompañante eliminado correctamente.');
    }
}
