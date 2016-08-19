<?php

namespace Bame\Http\Controllers\Seguridad;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Seguridad\Menu;
use Bame\Models\Seguridad\Acceso;
use Bame\Models\Seguridad\SubMenu;
use Bame\Http\Requests\Seguridad\MenuRequest;
use Bame\Http\Requests\Seguridad\AccesosRequest;

class AccesoController extends Controller
{
    public function getAccesos()
    {
        return view('seguridad.accesos', ['menus' => Menu::all()]);
    }

    public function postAccesos(AccesosRequest $request)
    {
        if (!$request->submenu) {
            return redirect()->route('seguridad::accesos')->with('submenus', SubMenu::all($request->menu))->with('info', 'Ahora debe seleccionar un submenú')->withInput();
        }

        switch ($request->accion) {
            case 'i':
                Acceso::disabled($request->usuario, $request->menu, $request->submenu);
                break;
            case 'a':
                Acceso::create($request->usuario, $request->menu, $request->submenu, 'A');
                break;
            case 'e':
                Acceso::delete($request->usuario, $request->menu, $request->submenu);
                break;
        }

        return back()->with('success', 'La solicitud ha sido procesada correctamente.');
    }
}
