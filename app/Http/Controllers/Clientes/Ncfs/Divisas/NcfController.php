<?php

namespace Bame\Http\Controllers\Clientes\Ncfs\Divisas;

use Illuminate\Http\Request;

use Bame\Http\Controllers\Controller;

use Bame\Models\Clientes\Ncfs\Ncf;
use Bame\Models\Clientes\Cliente;
use Bame\Models\Operaciones\TransaccionesCaja;
use Bame\Http\Requests\Clientes\Ncfs\Divisas\NuevoRequest;
use Bame\Http\Requests\Clientes\Ncfs\Divisas\EditarRequest;

class NcfController extends Controller
{
    public function getNuevo() {
        return view('clientes.ncfs.divisas.nuevo', ['transacciones' => collect()]);
    }

    public function postNuevo(NuevoRequest $request) {
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

    public function getEditar(Request $request, $id) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        $transacciones = collect($request->session()->get('transacciones'));

        $transaccion = $transacciones->get($id);

        if (!$transaccion) {
            return back()->with('warning', 'El detalle indicado no existe.');
        }

        return view('clientes.ncfs.divisas.editar', ['transaccion' => $transaccion]);
    }

    public function postEditar(EditarRequest $request, $id) {
        $transacciones = collect($request->session()->get('transacciones'));

        $transaccion = $transacciones->get($id);

        if (!$transaccion) {
            return back()->with('warning', 'El detalle indicado no existe.');
        }

        $transaccion->DESCRIPCION = cap_str($request->descripcion);
        $transaccion->MONTO = $request->monto;

        $transacciones->put($id, $transaccion);

        $request->session()->put('transacciones', $transacciones);

        return redirect(route('clientes::ncfs::divisas::nuevo'))->with('success', 'El detalle fue editado correctamente.');
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

        return redirect(route('clientes::ncfs::divisas::nuevo'))
        ->with('success', 'El ncf ' . $infoExtra['ncf'] . ' a sido creado satisfactoria mente. El # de factura es: ' . $infoExtra['factura'])
        ->with('link', route('clientes::ncfs::detalles::imprimir', ['factura' => $infoExtra['factura'], 'ibs' => 1]));
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
