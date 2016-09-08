<?php

namespace Bame\Http\Controllers\Clientes;

use Illuminate\Http\Request;

use Bame\Http\Requests\Clientes\NcfRequest;
use Bame\Http\Controllers\Controller;

use Bame\Models\Clientes\Ncf;
use Bame\Models\Clientes\Cliente;
use Bame\Models\Operaciones\TransaccionesCaja;
use Bame\Http\Requests\Clientes\NcfNuevoRequest;
use Bame\Http\Requests\Clientes\NcfEditarRequest;

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
            $request->session()->forget('ncfs');
            return back()->with('warning', 'No se encontraron resultados de acuerdo a su búsqueda.');
        }

        $request->session()->put('ncfs', $ncfs);

        return view('clientes.ncf');
    }

    public function getAnular(Request $request, $ncf) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        Ncf::cancel($ncf);

        return back()->with('success', 'El NCF: ' . $ncf . ' ha sido anulado correctamente.');
    }

    public function getNuevo() {
        return view('clientes.ncf_nuevo', ['transacciones' => collect()]);
    }

    public function postNuevo(NcfNuevoRequest $request) {
        $cliente = Cliente::getByCode($request->codigo_cliente);

        if (!$cliente) {
            return back()->withInput()->with('warning', 'Este #' . $request->codigo_cliente . ' cliente no existe.');
        }

        TransaccionesCaja::addApplicationCodeFilter();

        TransaccionesCaja::addAmountGreaterThanFilter();

        TransaccionesCaja::addDayGreaterThanFilter($request->dia_desde);

        TransaccionesCaja::addDayLowerThanFilter($request->dia_hasta);

        TransaccionesCaja::addMonthFilter($request->mes);

        TransaccionesCaja::addYearFilter($request->anio);

        TransaccionesCaja::addCustomerFilter($cliente->CODIGO);

        $transacciones = TransaccionesCaja::all();

        if (!$transacciones) {
            return back()->withInput()->with('warning', 'No se encontraron transacciones de divisas para el cliente ' . $cliente->CODIGO . '.');
        }

        $cliente->MES = $request->mes;
        $cliente->ANIO = $request->anio;

        $transacciones = TransaccionesCaja::formatAll($transacciones);

        $request->session()->put('cliente', Cliente::format($cliente));
        $request->session()->put('transacciones', $transacciones);

        return back()->withInput();
    }

    public function getGuardar(Request $request) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        $cliente = $request->session()->get('cliente');

        if (!$cliente) {
            return back()->with('warning', 'No se ha cargado un cliente para generar el NCF.');
        }

        $transacciones = collect($request->session()->get('transacciones'));

        if (!$transacciones->count()) {
            return back()->with('warning', 'No se encontraron transacciones de divisas para generar el NCF.');
        }

        $infoExtra = Ncf::save($cliente, $transacciones);

        return redirect(route('clientes::ncf::nuevo'))
        ->with('success', 'El ncf ' . $infoExtra['ncf'] . ' a sido creado satisfactoria mente. El # de factura es: ' . $infoExtra['factura'])
        ->with('link', route('clientes::ncf::detalle::imprimir', ['factura' => $infoExtra['factura']]));
    }

    public function getEditar(Request $request, $id) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        $transacciones = collect($request->session()->get('transacciones'));

        $transaccion = $transacciones->get($id);

        if (!$transaccion) {
            return back()->with('warning', 'El detalle indicado no existe.');
        }

        return view('clientes.ncf_editar', ['transaccion' => $transaccion]);
    }

    public function postEditar(NcfEditarRequest $request, $id) {
        $transacciones = collect($request->session()->get('transacciones'));

        $transaccion = $transacciones->get($id);

        if (!$transaccion) {
            return back()->with('warning', 'El detalle indicado no existe.');
        }

        $transaccion->DESCRIPCION = cap_str($request->descripcion);
        $transaccion->MONTO = $request->monto;

        $transacciones->put($id, $transaccion);

        $request->session()->put('transacciones', $transacciones);

        return redirect(route('clientes::ncf::nuevo'))->with('success', 'El detalle fue editado correctamente.');
    }

    public function getEliminar(Request $request, $id) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        $transacciones = collect($request->session()->get('transacciones'));

        $transaccion = $transacciones->get($id);

        if (!$transaccion) {
            return back()->with('warning', 'El detalle indicado no existe.');
        }

        $transacciones = $transacciones->filter(function ($transaccion, $index) use ($id) {
            return $transaccion->ID != $id;
        });

        $request->session()->put('transacciones', $transacciones);

        return back()->with('success', 'El detalle fue eliminado correctamente.');
    }

    public function getEliminarTodo(Request $request) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        $request->session()->forget('cliente');
        $request->session()->forget('transacciones');

        return back()->with('success', 'El cliente y los detalles fueron eliminados correctamente.');
    }
}
