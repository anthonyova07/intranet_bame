<?php

namespace Bame\Http\Controllers\Request\Process;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

class ProcessController extends Controller
{
    public function index()
    {
        return view('process.request.index');
    }
}
