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

            return back()->with('success', 'Los cumpleaños fueron cargados correctamente.');
        }

        $rules = ['code' => 'required|integer'];

        if (trim($request->full_name) != '') {
            $rules = array_merge($rules, [
                'birthdate' => 'required',
                'initial_date' => 'required',
            ]);
        }

        $this->validate($request, $rules);

        $message = Birthdate::addModifyDeleteOne($request);

        return back()->with('success', $message);
    }
}
