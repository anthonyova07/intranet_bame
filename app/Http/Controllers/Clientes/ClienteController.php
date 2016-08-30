<?php

namespace Bame\Http\Controllers\Clientes;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Requests\Clientes\ConsultaRequest;
use Bame\Http\Controllers\Controller;

use Bame\Models\Clientes\Cliente;

class ClienteController extends Controller
{
    public function getConsulta() {
        return view('clientes.consulta', ['cliente' => null]);
    }

    public function postConsulta(ConsultaRequest $request) {
        $cliente = Cliente::getByIdentification($request->identificacion);

        if (!$cliente) {
            return back()->with('warning', 'Este numero de identificación no corresponde a ningún cliente.');
        }

        $origen = Cliente::getPhotoByIdentification($request->identificacion);
        $destino = public_path('images\temporal.jpg');

        copy($origen, $destino);

        $cliente->FOTO = route('home') . '/images/temporal.jpg';

        return view('clientes.consulta', ['cliente' => $cliente]);
    }
}
