<?php

namespace Bame\Http\Controllers;

use Illuminate\Http\Request;
use Bame\Http\Requests;


class HomeController extends Controller {

    public function index(Request $request) {
        return view('home.index');
    }

}
