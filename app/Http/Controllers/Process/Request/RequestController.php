<?php

namespace Bame\Http\Controllers\Process\Request;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\Process\Request\Param;

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
}
