<?php

namespace Bame\Http\Controllers\HumanResource\Calendar;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Calendar\Birthdate;

class BirthdateController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('birthdate_file')) {
            Birthdate::storeFile($request->file('birthdate_file'));
        }

        return back()->with('success', 'Los cumpleaños fueron cargados correctamente.');
    }
}
