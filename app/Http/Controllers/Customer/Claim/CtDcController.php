<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Customer\Claim\CtDc;
use Bame\Http\Requests\Customer\Claim\CtDcRequest;

class CtDcController extends Controller
{
    public function create($type)
    {
        return view('customer.claim.ct_dc.create')
            ->with('type', $type);
    }

    public function store(CtDcRequest $request, $type)
    {
        $ct_dc = new CtDc;

        $ct_dc->id = uniqid(true);
        $ct_dc->type = $type;
        $ct_dc->description = cap_str($request->description);
        $ct_dc->is_active = $request->is_active ? true : false;
        $ct_dc->created_by = session()->get('user');

        $ct_dc->save();

        return redirect(route('customer.claim.{type}.ct_dc.create', ['type' => $type]))
            ->with('success', 'El ' . get_ct_dc($type, false) . ' fue creado correctamente.');
    }

    public function edit($type, $id)
    {
        $ct_dc = CtDc::find($id);

        if (!$ct_dc) {
            return back()->with('warning', 'Este ' . get_ct_dc($type, false) . ' no existe!');
        }

        return view('customer.claim.ct_dc.edit')
            ->with('ct_dc', $ct_dc);
    }

    public function update(CtDcRequest $request, $type, $id)
    {
        $ct_dc = CtDc::find($id);

        if (!$ct_dc) {
            return back()->with('warning', 'Este ' . get_ct_dc($type, false) . ' no existe!');
        }

        $ct_dc->description = cap_str($request->description);
        $ct_dc->is_active = $request->is_active ? true : false;
        $ct_dc->created_by = session()->get('user');

        $ct_dc->save();

        return redirect(route('customer.claim.index'))
            ->with('success', 'El ' . get_ct_dc($type, false) . ' fue modificado correctamente.');
    }
}
