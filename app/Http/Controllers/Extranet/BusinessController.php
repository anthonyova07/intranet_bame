<?php

namespace Bame\Http\Controllers\Extranet;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Extranet\Business;
use Bame\Http\Requests\Extranet\BusinessRequest;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $business = Business::orderBy('created_at', 'desc');

        // if ($request->term) {
        //     $business->where(function ($query) use ($request) {
        //         $query->where('title', 'like', '%' . $request->term . '%')
        //             ->orWhere('detail', 'like', '%' . $request->term . '%');
        //     });
        // }
        //
        // if ($request->date_from) {
        //     $business->where('created_at', '>=', $request->date_from . ' 00:00:00');
        // }
        //
        // if ($request->date_to) {
        //     $business->where('created_at', '<=', $request->date_to . ' 23:59:59');
        // }

        $business = $business->paginate();

        return view('extranet.business.index')
            ->with('business', $business);
    }

    public function create()
    {
        return view('extranet.business.create');
    }

    public function store(BusinessRequest $request)
    {
        $user = new Business;
        $user->id = uniqid(true);
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->created_by = session()->get('user');
        $user->save();

        do_log('Creó la Empresa Extranet ( name:' . $user->name . ' )');

        return redirect()->route('extranet.business.create')->with('success', 'La Empresa fue creada correctamente.');

    }

    public function show($id)
    {
        return redirect()->route('extranet.business.index');
    }

    public function edit($id)
    {
        $busi = Business::find($id);

        if (!$busi) {
            return back()->with('warning', 'Esta empresa no existe!');
        }

        return view('extranet.business.edit')
            ->with('busi', $busi);
    }

    public function update(BusinessRequest $request, $id)
    {
        $user = Business::find($id);

        if (!$user) {
            return back()->with('warning', 'Esta empresa no existe!');
        }

        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->updated_by = session()->get('user');
        $user->save();

        do_log('Editó la Empresa Extranet ( name:' . $user->name . ' )');

        return redirect()->route('extranet.business.index')->with('success', 'La Empresa ha sido modificado correctamente.');
    }

    public function destroy($id)
    {
        $user = Business::find($id);

        if (!$user) {
            return back()->with('warning', 'Esta empresa no existe!');
        }

        $user->delete();

        do_log('Eliminó la Empresa Extranet ( name:' . $user->name . ' )');

        return redirect(route('extranet.business.index'))->with('success', 'La Empresa ha sido eliminado correctamente.');
    }
}
