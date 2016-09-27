<?php

namespace Bame\Http\Controllers\Security;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Security\Log;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Log::lastestFirst()->take(env('LOG_MAX_ROWS'));

        if ($request->id) {
            $logs->where('id', $request->id);
        }

        if ($request->user) {
            $logs->where('user', $request->user);
        }

        if ($request->description) {
            $logs->where('description', 'like', '%' . $request->description . '%');
        }

        if ($request->date_from) {
            $logs->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $logs->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $logs = $logs->paginate();

        return view('security.log.index', ['logs' => $logs]);
    }
}
