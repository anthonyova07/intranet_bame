<?php

namespace Bame\Http\Controllers\Operaciones\Tdc;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Operaciones\Tdc\Encarte;
use Bame\Jobs\Operaciones\Tdc\GeneradorEncartes;
use Bame\Http\Requests\Operaciones\Tdc\EncarteRequest;

class EncarteController extends Controller
{
    public function getEncartes(EncarteRequest $request)
    {
        return view('operaciones.tdc.encartes', ['cantidad' => Encarte::pendingCount()]);
    }

    public function postEncartes(EncarteRequest $request)
    {
        $log = 'Solicitó generar los encartes con (';

        $encartes = new Encarte;

        if ($request->identificacion) {
            $log .= ' identificación:' . $request->identificacion;
            $encartes->filtros->put('identificacion', $request->identificacion);
        }

        if ($request->tarjeta) {
            $log .= ' tarjeta:' . $request->tarjeta;
            $encartes->filtros->put('tarjeta', $request->tarjeta);
        }

        if ($request->fecha) {
            $log .= ' fecha:' . $request->fecha;
            $encartes->filtros->put('fecha', $request->fecha);
        }

        if (!$request->identificacion and !$request->tarjeta and !$request->fecha) {
            $log .= ' todos_los_pendientes';
            $encartes->filtros->put('todos_pendientes', true);
        }

        $log .= ' )';

        do_log($log);

        $this->dispatch(new GeneradorEncartes($encartes->filtros, $request->session()->get('usuario')));

        return back()->with('success', 'Los encartes solicitados serán generados en la ruta especificada.')->with('info', 'El tiempo estimado dependerá de la cantidad de encartes (500 = 20 min aprox).');
    }
}
