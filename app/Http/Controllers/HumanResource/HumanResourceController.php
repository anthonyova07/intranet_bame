<?php

namespace Bame\Http\Controllers\HumanResource;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\HumanResource\Vacant\Vacant;

class HumanResourceController extends Controller
{
    public function vacant($id)
    {
        $vacant = Vacant::where('is_active', true)->find($id);

        if (!$vacant) {
            return redirect(route('home'))->with('warning', 'Esta vacante no existe!');
        }

        return view('home.human_resources.vacant')
            ->with('vacant', $vacant);
    }
}
