<?php

namespace Bame\Http\Controllers\Clientes\Ncfs\NoIbs;

use Illuminate\Http\Request;

use Bame\Http\Controllers\Controller;

use Bame\Models\Clientes\Ncfs\Ncf;
use Bame\Models\Clientes\Cliente;
use Bame\Http\Requests\Clientes\Ncfs\NoIbs\NuevoRequest;
use Bame\Http\Requests\Clientes\Ncfs\NoIbs\NuevoDetalleRequest;
use Bame\Http\Requests\Clientes\Ncfs\NoIbs\EditarDetalleRequest;

class NcfController extends Controller
{
    public function getNuevo() {
        return view('clientes.ncfs.no_ibs.nuevo');
    }

    public function postNuevo(NuevoRequest $request) {
        $cliente = new Cliente;

        $cliente->NOMBRES_APELLIDOS = cap_str($request->nombres_apellidos);
        $cliente->TIPO_IDENTIFICACION = $request->tipo_identificacion;
        $cliente->IDENTIFICACION = strtoupper($request->identificacion);
        $cliente->MES = $request->mes;
        $cliente->ANIO = $request->anio;

        $request->session()->put('cliente_noibs', $cliente);

        return back()->withInput();
    }

    public function getNuevoDetalle() {
        return view('clientes.ncfs.no_ibs.detalle.nuevo');
    }

    public function postNuevoDetalle(NuevoDetalleRequest $request) {
        $transaccion = new \stdClass;

        $transaccion->DESCRIPCION = cap_str($request->descripcion);
        $transaccion->MONTO = $request->monto;
        $transaccion->IMPUESTO = floatval($request->monto) * 0.18;
        $transaccion->DIA = $request->dia;
        $transaccion->MES = $request->mes;
        $transaccion->ANIO = $request->anio;

        if ($request->session()->has('transacciones_noibs')) {
            $transacciones = collect($request->session()->get('transacciones_noibs'));
        } else {
            $transacciones = collect();
        }

        $transacciones->push($transaccion);

        $request->session()->put('transacciones_noibs', $transacciones);

        return back()->with('success', 'La Transacción ha sido guardada con éxito.');
    }

    public function getEditar(Request $request, $id) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        $transacciones = collect($request->session()->get('transacciones_noibs'));

        $index = $id;
        $transaccion = $transacciones->get($id);

        if (!$transaccion) {
            return back()->with('warning', 'El detalle indicado no existe.');
        }

        return view('clientes.ncfs.no_ibs.detalle.editar', ['index' => $index, 'transaccion' => $transaccion]);
    }

    public function postEditar(EditarDetalleRequest $request, $id) {
        $transacciones = collect($request->session()->get('transacciones_noibs'));

        $transaccion = $transacciones->get($id);

        if (!$transaccion) {
            return back()->with('warning', 'El detalle indicado no existe.');
        }

        $transaccion->DESCRIPCION = cap_str($request->descripcion);
        $transaccion->MONTO = $request->monto;
        $transaccion->IMPUESTO = floatval($request->monto) * 0.18;
        $transaccion->DIA = $request->dia;
        $transaccion->MES = $request->mes;
        $transaccion->ANIO = $request->anio;

        $transacciones->put($id, $transaccion);

        $request->session()->put('transacciones_noibs', $transacciones);

        return redirect(route('clientes::ncfs::no_ibs::nuevo'))->with('success', 'El detalle fue editado correctamente.');
    }

    public function getGuardar(Request $request) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        $cliente = $request->session()->get('cliente_noibs');

        if (!$cliente) {
            return back()->with('warning', 'No se ha cargado un cliente para generar el NCF.');
        }

        $transacciones = collect($request->session()->get('transacciones_noibs'));

        if (!$transacciones->count()) {
            return back()->with('warning', 'No se encontraron transacciones de divisas para generar el NCF.');
        }

        $infoExtra = Ncf::saveNoIBS($cliente, $transacciones);

        return redirect(route('clientes::ncfs::no_ibs::nuevo'))
        ->with('success', 'El ncf ' . $infoExtra['ncf'] . ' a sido creado satisfactoria mente. El # de factura es: ' . $infoExtra['factura'])
        ->with('link', route('clientes::ncfs::detalles::imprimir', ['factura' => $infoExtra['factura'], 'ibs' => 0]));
    }

    public function getEliminar(Request $request, $id) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        $transacciones = collect($request->session()->get('transacciones_noibs'));

        $transaccion = $transacciones->get($id);

        if (!$transaccion) {
            return back()->with('warning', 'El detalle indicado no existe.');
        }

        $transacciones = $transacciones->filter(function ($transaccion, $index) use ($id) {
            return $index != $id;
        });

        $request->session()->put('transacciones_noibs', $transacciones);

        return back()->with('success', 'El detalle fue eliminado correctamente.');
    }

    public function getEliminarTodo(Request $request) {
        if (can_not_do('clientes_ncf')) {
            return view('partials.access_denied');
        }

        $request->session()->forget('cliente_noibs');
        $request->session()->forget('transacciones_noibs');

        return back()->with('success', 'El cliente y los detalles fueron eliminados correctamente.');
    }
}
