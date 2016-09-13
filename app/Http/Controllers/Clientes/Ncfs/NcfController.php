<?php

namespace Bame\Http\Controllers\Clientes\Ncfs;

use Illuminate\Http\Request;

use Bame\Http\Requests\Clientes\Ncfs\NcfRequest;
use Bame\Http\Controllers\Controller;

use Bame\Models\Clientes\Ncfs\Ncf;

class NcfController extends Controller
{
    public function getConsulta() {
        return view('clientes.ncfs.consulta', ['ncfs' => collect()]);
    }

    public function postConsulta(NcfRequest $request) {
        $log = 'Consultó los NCF de ( ';

        if ($request->codigo_cliente) {
            $log .= ' codigo_cliente:' . $request->codigo_cliente;
            Ncf::addClientCodeFilter($request->codigo_cliente);
        }

        if ($request->producto) {
            $log .= ' producto:' . $request->producto;
            Ncf::addProductFilter($request->producto);
        }

        if ($request->mes_proceso) {
            $log .= ' mes_proceso:' . $request->mes_proceso;
            Ncf::addMonthProcessFilter($request->mes_proceso);
        }

        if ($request->anio_proceso) {
            $log .= ' año_proceso:' . $request->anio_proceso;
            Ncf::addYearProcessFilter($request->anio_proceso);
        }

        if ($request->ncf) {
            $log .= ' ncf:' . $request->ncf;
            Ncf::addNcfFilter($request->ncf);
        }

        if ($request->factura) {
            $log .= ' factura:' . $request->factura;
            Ncf::addInvoiceFilter($request->factura);
        }

        Ncf::orderByNcf();

        $ncfs = Ncf::all();

        $ncfs = Ncf::formatAll($ncfs);

        do_log($log . ' )');

        if (!$ncfs) {
            $request->session()->forget('ncfs');
            return back()->with('warning', 'No se encontraron resultados de acuerdo a su búsqueda.');
        }

        $request->session()->put('ncfs', $ncfs);

        return view('clientes.ncfs.consulta');
    }

    public function getAnular(Request $request, $ncf) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        Ncf::cancel($ncf);

        do_log('Anuló el NCF ( ncf:' . $ncf . ' )');

        return back()->with('success', 'El NCF: ' . $ncf . ' ha sido anulado correctamente.');
    }
}
