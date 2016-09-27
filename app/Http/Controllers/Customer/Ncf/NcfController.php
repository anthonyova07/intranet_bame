<?php

namespace Bame\Http\Controllers\Customer\Ncf;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Customer\Ncf\Ncf;
use Bame\Models\Customer\Ncf\Detail;

class NcfController extends Controller
{
    public function index(Request $request)
    {
        $log = 'Consultó los NCF de ( ';

        $ncfs = Ncf::orderBy('encncf', 'desc')
            ->where('encsts', 'A');

        if ($request->customer_number) {
            $log .= ' codigo_cliente:' . $request->customer_number;
            $ncfs->where('enccli', $request->customer_number);
        }

        if ($request->product) {
            $log .= ' producto:' . $request->product;
            $ncfs->where('enccta', $request->product);
        }

        if ($request->month_process) {
            $log .= ' mes_proceso:' . $request->month_process;
            $ncfs->where('encmesp', $request->month_process);
        }

        if ($request->year_process) {
            $log .= ' año_proceso:' . $request->year_process;
            $ncfs->where('encaniop', $request->year_process);
        }

        if ($request->ncf) {
            $log .= ' ncf:' . $request->ncf;
            $ncfs->where('encncf', $request->ncf);
        }

        if ($request->invoice) {
            $log .= ' factura:' . $request->invoice;
            $ncfs->where('encfact', $request->invoice);
        }

        $ncfs = $ncfs->paginate();

        if ($log != 'Consultó los NCF de ( ') {
            do_log($log . ' )');
        }

        return view('customer.ncf.index')
            ->with('ncfs', $ncfs);
    }

    public function show($id)
    {
        $ncf = Ncf::where('encfact', $id)->first();

        if (!$ncf) {
            return back()->with('warning', 'Este factura no existe!');
        }

        $details = Detail::where('detfac', $ncf->getInvoice())
            ->where('deasts', 'A')
            ->get();

        if (!$details->count()) {
            return back()->with('warning', 'Este factura no tiene detalle para imprimir!');
        }

        do_log('Imprimió el NCF ( ncf:' . $ncf->getNcf() . ' )');

        return view('pdfs.ncf.show')
            ->with('ncf', $ncf)
            ->with('details', $details)
            ->with('datetime', new DateTime);
    }

    public function destroy($id)
    {
        $ncf = Ncf::where('encfact', $id)->first();

        if (!$ncf) {
            return back()->with('warning', 'Este factura no existe!');
        }

        $ncf->encsts = 'R';

        $ncf->save();

        do_log('Anuló el NCF ( ncf:' . $ncf->getNcf() . ' )');

        return back()->with('success', 'El Ncf: ' . $ncf->getNcf() . ' ha sido anulado correctamente.');
    }
}
