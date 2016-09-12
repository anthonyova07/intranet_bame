<?php

namespace Bame\Http\Controllers\Seguridad;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Seguridad\Menu;
use Bame\Http\Requests\Seguridad\MenuRequest;

class MenuController extends Controller
{
    public function getMenuLista()
    {
        return view('seguridad.menus.lista', ['menus' => Menu::all()]);
    }

    public function getMenuNuevo()
    {
        return view('seguridad.menus.nuevo');
    }

    public function postMenuNuevo(MenuRequest $request)
    {
        Menu::create($request->descripcion, $request->estatus, $request->web);

        do_log('Creó el Menú ( descripción:' . cap_str($request->descripcion) . ' estatus:' . get_status($request->estatus) . ' web:' . get_web($request->web) . ' )');

        return redirect()->route('seguridad::menus::lista')->with('success', 'El menú ha sido agregado correctamente.');
    }

    public function getMenuEditar($codigo)
    {
        return view('seguridad.menus.editar', ['menu' => Menu::get($codigo)]);
    }

    public function postMenuEditar(MenuRequest $request, $codigo)
    {
        Menu::update($request->descripcion, $request->estatus, $request->web, $codigo);

        do_log('Editó el Menú ( código:' . $codigo . ' descripción:' . cap_str($request->descripcion) . ' estatus:' . get_status($request->estatus) . ' web:' . get_web($request->web) . ' )');

        return redirect()->route('seguridad::menus::lista')->with('success', 'El menú ha sido modificado correctamente.');
    }
}
