<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Customer\Claim\Param;
use Bame\Http\Requests\Customer\Claim\ParamRequest;

class ParamController extends Controller
{
    public function create($type)
    {
        return view('customer.claim.param.create')
            ->with('type', $type);
    }

    public function store(ParamRequest $request, $type)
    {
        $param = new Param;

        $param->id = uniqid(true);
        $param->type = $type;

        if ($type == 'TDC') {
            $param->es_name = ucfirst(str_replace('campo', 'field', $request->es_name));
            $param->es_detail = ucfirst(str_replace('campo', 'field', $request->es_detail));
            $param->es_detail_2 = ucfirst(str_replace('campo', 'field', $request->es_detail_2));

            $param->en_name = ucfirst(str_replace('campo', 'field', $request->en_name));
            $param->en_detail = ucfirst(str_replace('campo', 'field', $request->en_detail));
            $param->en_detail_2 = ucfirst(str_replace('campo', 'field', $request->en_detail_2));
        } else {
            $param->code = strtoupper($request->code);
            $param->description = cap_str($request->description);
        }

        $param->is_active = $request->is_active ? true : false;
        $param->created_by = session()->get('user');

        $param->save();

        return redirect(route('customer.claim.{type}.param.create', ['type' => $type]))
            ->with('success', 'El ' . get_param($type, false) . ' fue creado correctamente.');
    }

    public function edit($type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . get_param($type, false) . ' no existe!');
        }

        return view('customer.claim.param.edit')
            ->with('param', $param);
    }

    public function update(ParamRequest $request, $type, $id)
    {
        $param = Param::find($id);

        if (!$param) {
            return back()->with('warning', 'Este ' . get_param($type, false) . ' no existe!');
        }

        if ($type == 'TDC') {
            $param->es_name = ucfirst(str_replace('campo', 'field', $request->es_name));
            $param->es_detail = ucfirst(str_replace('campo', 'field', $request->es_detail));
            $param->es_detail_2 = ucfirst(str_replace('campo', 'field', $request->es_detail_2));

            $param->en_name = ucfirst(str_replace('campo', 'field', $request->en_name));
            $param->en_detail = ucfirst(str_replace('campo', 'field', $request->en_detail));
            $param->en_detail_2 = ucfirst(str_replace('campo', 'field', $request->en_detail_2));
        } else {
            $param->code = strtoupper($request->code);
            $param->description = cap_str($request->description);
        }

        $param->is_active = $request->is_active ? true : false;
        $param->updated_by = session()->get('user');

        $param->save();

        return redirect(route('customer.claim.index'))
            ->with('success', 'El ' . get_param($type, false) . ' fue modificado correctamente.');
    }
}
