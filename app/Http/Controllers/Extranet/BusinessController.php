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
        $busi = new Business;
        $busi->id = uniqid(true);
        $busi->name = $request->name;
        $busi->address = $request->address;
        $busi->phone = $request->phone;
        $busi->roles = $request->roles ? implode(',', $request->roles) : null;
        $busi->created_by = session()->get('user');
        $busi->save();

        do_log('Creó la Empresa Extranet ( nombre:' . $busi->name . ' )');

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
        $busi = Business::find($id);

        if (!$busi) {
            return back()->with('warning', 'Esta empresa no existe!');
        }

        $busi->name = $request->name;
        $busi->address = $request->address;
        $busi->phone = $request->phone;
        $busi->roles = $request->roles ? implode(',', $request->roles) : null;
        $busi->updated_by = session()->get('user');
        $busi->save();

        do_log('Editó la Empresa Extranet ( nombre:' . $busi->name . ' )');

        return redirect()->route('extranet.business.index')->with('success', 'La Empresa ha sido modificado correctamente.');
    }

    public function destroy($id)
    {
        $busi = Business::find($id);

        if (!$busi) {
            return back()->with('warning', 'Esta empresa no existe!');
        }

        $busi->delete();

        do_log('Eliminó la Empresa Extranet ( nombre:' . $busi->name . ' )');

        return redirect(route('extranet.business.index'))->with('success', 'La Empresa ha sido eliminado correctamente.');
    }
}
