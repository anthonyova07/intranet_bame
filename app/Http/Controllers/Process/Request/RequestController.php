<?php

namespace Bame\Http\Controllers\Process\Request;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\Process\Request\Param;
use Bame\Models\Process\Request\ProcessRequest;
use Bame\Http\Requests\Process\Request\RequestProcessRequest;

class RequestController extends Controller
{
    public function index()
    {
        $param = Param::all();

        $request_types = $param->where('type', 'TIPSOL');
        $request_statuses = $param->where('type', 'EST');
        $request_processes = $param->where('type', 'PRO');

        return view('process.request.index', [
            'request_types' => $request_types,
            'request_statuses' => $request_statuses,
            'request_processes' => $request_processes,
        ]);
    }

    public function create()
    {
        $params = Param::activeOnly()->get();

        $request_types = $params->where('type', 'TIPSOL');
        $processes = $params->where('type', 'PRO');

        return view('process.request.create', [
            'request_types' => $request_types,
            'processes' => $processes,
        ]);
    }

    public function store(RequestProcessRequest $request)
    {
        $process_request = new ProcessRequest;

        $params = Param::whereIn('id', [$request->request_type, $request->process, $request->subprocess])->get();

        $request_type = $params->where('id', $request->request_type)->where('type', 'TIPSOL')->first();
        $process = $params->where('id', $request->process)->where('type', 'PRO')->first();
        $subprocess = $params->where('id', $request->subprocess)->where('type', 'PRO')->where('id_parent', $process->id)->first();

        if (is_null($request_type) || is_null($process) || is_null($subprocess)) {
            return back()->withInput()->withError('Los parámetros seleccionados no son correctos.');
        }

        $process_request->id = uniqid(true);
        $process_request->reqtype = $request_type->note;
        $process_request->process = "{$process->name} v( {$process->version} )";
        $process_request->subprocess = "{$subprocess->name} v( {$subprocess->version} )";
        $process_request->note = $request->description;
        $process_request->causeanaly = $request->cause_analysis;
        $process_request->peoinvolve = $request->people_involved;
        $process_request->deliverabl = $request->deliverable;
        $process_request->observatio = $request->observations;

        $process_request->created_by = session()->get('user');
        $process_request->created_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $process_request->reqnumber = get_next_request_number();
        $process_request->save();

        return redirect(route('process.request.show', ['request' => $process_request->id]))->with('success', 'La solicitud ha sido creada correctamente.');

    }

    public function show($request)
    {
        $process_request = ProcessRequest::find($request);

        if (!$process_request) {
            return redirect(route('process.request.index'));
        }

        return view('process.request.show', [
            'process_request' => $process_request,
        ]);
    }
}
