<?php

namespace Bame\Http\Controllers\Customer\Requests\Tdc;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Customer\Requests\Tdc\Param;
use Bame\Http\Requests\Customer\Requests\Tdc\ParamRequest;

class ParamController extends Controller
{
    public function create($type)
    {
        return view('customer.requests.tdc.param.create')
            ->with('type', $type);
    }

    public function store(ParamRequest $request, $type)
    {
        $param = new Param;

        $param->id = uniqid(true);
        $param->type = $type;
        $param->note = cap_str($request->description);
        $param->isblack = $request->is_black ? true : false;
        $param->created_by = session()->get('user');

        $param->save();

        return redirect(route('customer.request.tdc.{type}.param.create', ['type' => $type]))
            ->with('success', 'El ' . get_request_tdc_param($type, false) . ' fue creado correctamente.');
    }

    public function edit($type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . get_request_tdc_param($type, false) . ' no existe!');
        }

        return view('customer.requests.tdc.param.edit')
            ->with('param', $param);
    }

    public function update(ParamRequest $request, $type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . get_request_tdc_param($type, false) . ' no existe!');
        }

        $param->note = cap_str($request->description);

        $param->isblack = $request->is_black ? true : false;
        $param->updated_by = session()->get('user');

        $param->save();

        return redirect(route('customer.request.tdc.index'))
            ->with('success', 'El ' . get_request_tdc_param($type, false) . ' fue modificado correctamente.');
    }
}
