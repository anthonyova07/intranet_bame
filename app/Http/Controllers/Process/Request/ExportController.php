<?php

namespace Bame\Http\Controllers\Process\Request;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Process\Request\ProcessRequest;

class ExportController extends Controller
{
    public function status_count_excel(Request $request)
    {
        $process_requests = ProcessRequest::orderBy('created_at', 'asc');

        if ($request->request_type) {
            $process_requests->where('reqtype', $request->request_type);
        }

        if ($request->process) {
            $process_requests->where('process', $request->process);
        }

        if ($request->status != 'todos') {
            $process_requests->where('reqstatus', $request->status);
        }

        if ($request->date_from) {
            $process_requests->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $process_requests->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $process_requests = $process_requests->get();

        do_log('Exportó a Excel las Reclamaciones ( desde:' . strip_tags($request->date_from) . ' hasta:' . strip_tags($request->date_to) . ' )');

        return view('process.request.export.status_count_excel')
            ->with('process_requests', $process_requests->groupBy('reqstatus'));
    }

    public function status_count_pdf(Request $request)
    {
        $datetime = new DateTime;

        $process_requests = ProcessRequest::orderBy('created_at', 'asc');

        if ($request->request_type) {
            $process_requests->where('reqtype', $request->request_type);
        }

        if ($request->process) {
            $process_requests->where('process', $request->process);
        }

        if ($request->status && $request->status != 'todos') {
            $process_requests->where('reqstatus', $request->status);
        }

        if ($request->date_from) {
            $process_requests->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $process_requests->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $process_requests = $process_requests->get();

        // dd($process_requests->groupBy('reqtype'));

        do_log('Exportó a Excel las Reclamaciones ( desde:' . strip_tags($request->date_from) . ' hasta:' . strip_tags($request->date_to) . ' )');

        return view('process.request.export.status_count_pdf')
            ->with('datetime', $datetime)
            ->with('process_requests', $process_requests);
    }
}
