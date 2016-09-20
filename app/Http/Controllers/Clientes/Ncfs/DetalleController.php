<?php

namespace Bame\Http\Controllers\Clientes\Ncfs;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Clientes\Ncfs\Ncf;
use Bame\Models\Clientes\Ncfs\Detalle;

class DetalleController extends Controller
{
    public function getConsulta(Request $request, $factura, $es_cliente) {
        $ncf = Ncf::get($factura, boolval($es_cliente));

        do_log('Consultó el detalle NCF de ( factura:' . $factura . ' )');

        if (!$ncf) {
            return back()->with('warning', 'Este numero de factura no existe.');
        }

        $ncf = Ncf::format($ncf);

        $detalles = Detalle::all($ncf->FACTURA);

        $detalles = Detalle::formatAll($detalles);

        return view('clientes.ncfs.detalle', ['ncf' => $ncf, 'detalles' => $detalles]);
    }

    public function getAnular(Request $request, $factura, $secuencia) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        Detalle::cancel($factura, $secuencia);

        do_log('Anuló un detalle NCF ( factura:' . $factura . ' secuencia:' . $secuencia . ' )');

        return back()->with('success', 'El Detalle de la fuctura ha sido anulado correctamente.');
    }

    public function getActivar(Request $request, $factura, $secuencia) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        Detalle::active($factura, $secuencia);

        do_log('Activo un detalle NCF ( factura:' . $factura . ' secuencia:' . $secuencia . ' )');

        return back()->with('success', 'El Detalle de la fuctura ha sido activado correctamente.');
    }

    public function getImprimir(Request $request, $factura, $es_cliente) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        $ncf = Ncf::get($factura, boolval($es_cliente));

        if (!$ncf) {
            return back()->with('warning', 'Este número de factura no existe.');
        }

        $ncf = Ncf::format($ncf);
        $detalles = Detalle::all($ncf->FACTURA, true);

        if (!$detalles) {
            return back()->with('warning', 'Esta factura no contiene ningún detalle.');
        }

        $detalles = Detalle::formatAll($detalles);

        do_log('Imprimió el NCF ( ncf:' . $ncf->NCF . ' )');

        return view('pdfs.ncf_detalle', ['ncf' => $ncf, 'detalles' => $detalles]);
    }
}