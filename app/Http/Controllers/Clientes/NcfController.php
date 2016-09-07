<?php

namespace Bame\Http\Controllers\Clientes;

use Illuminate\Http\Request;

use Bame\Http\Requests\Clientes\NcfRequest;
use Bame\Http\Controllers\Controller;

use Bame\Models\Clientes\Ncf;

class NcfController extends Controller
{
    public function getConsulta() {
        return view('clientes.ncf', ['ncfs' => collect()]);
    }

    public function postConsulta(NcfRequest $request) {
        if ($request->codigo_cliente) {
            Ncf::addClientCodeFilter($request->codigo_cliente);
        }

        if ($request->producto) {
            Ncf::addProductFilter($request->producto);
        }

        if ($request->mes_proceso) {
            Ncf::addMonthProcessFilter($request->mes_proceso);
        }

        if ($request->anio_proceso) {
            Ncf::addYearProcessFilter($request->anio_proceso);
        }

        if ($request->ncf) {
            Ncf::addNcfFilter($request->ncf);
        }

        Ncf::orderByNcf();

        $ncfs = Ncf::all();

        $ncfs = Ncf::formatAll($ncfs);

        if (!$ncfs) {
            return back()->with('warning', 'No se encontraron resultados de acuerdo a su búsqueda.');
        }

        return view('clientes.ncf', ['ncfs' => $ncfs]);
    }

    public function getAnular(Request $request, $ncf) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        Ncf::cancel($ncf);

        return back()->with('success', 'El NCF: ' . $ncf . ' ha sido anulado correctamente.');
    }
}
