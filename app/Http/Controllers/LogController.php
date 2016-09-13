<?php

namespace Bame\Http\Controllers;

use Illuminate\Http\Request;

use Bame\Http\Requests;

use Bame\Models\Log;

class LogController extends Controller
{
    public function getShow()
    {
        $logs = Log::lastestFirst()->take(env('LOG_MAX_ROWS'))->get();
        return view('seguridad.logs.show', ['logs' => $logs]);
    }

    public function postShow(Request $request) {
        $logs = Log::lastestFirst();

        if ($request->id) {
            $logs = $logs->where('id', $request->id);
        }

        if ($request->usuario) {
            $logs = $logs->where('user', $request->usuario);
        }

        if ($request->description) {
            $logs = $logs->where('description', 'LIKE', '%' . $request->description . '%');
        }

        if ($request->fecha_desde) {
            $logs = $logs->where('created_at', '>=', $request->fecha_desde . ' 00:00:00');
        }

        if ($request->fecha_hasta) {
            $logs = $logs->where('created_at', '<=', $request->fecha_hasta . ' 23:59:59');
        }

        $logs = $logs->take(env('LOG_MAX_ROWS'))->get();

        return view('seguridad.logs.show', ['logs' => $logs]);
    }
}
