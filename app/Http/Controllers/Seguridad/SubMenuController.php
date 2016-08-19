<?php

namespace Bame\Http\Controllers\Seguridad;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Seguridad\Menu;
use Bame\Models\Seguridad\SubMenu;
use Bame\Http\Requests\Seguridad\SubMenuRequest;

class SubMenuController extends Controller
{
    public function getSubMenuLista($menu)
    {
        return view('seguridad.menus.submenus.lista', ['submenus' => SubMenu::all($menu)]);
    }

    public function getSubMenuNuevo($menu)
    {
        return view('seguridad.menus.submenus.nuevo', ['menus' => Menu::all()]);
    }

    public function postSubMenuNuevo(SubMenuRequest $request, $menu)
    {
        SubMenu::create($request->menu, $request->descripcion, $request->caption, $request->estatus, $request->web, $request->link);

        return redirect()->route('seguridad::menus::submenus::lista', ['menu' => $menu])->with('success', 'El submenú ha sido agregado correctamente.');
    }

    public function getSubMenuEditar($menu, $codigo)
    {
        return view('seguridad.menus.submenus.editar', ['menus' => Menu::all(), 'submenu' => SubMenu::get($menu, $codigo)]);
    }

    public function postSubMenuEditar(SubMenuRequest $request, $menu, $codigo)
    {
        $codigo_nuevo = $codigo;

        if ($menu != $request->menu) {
            $codigo_nuevo = SubMenu::getNewCode($request->menu);
        }

        SubMenu::update($request->menu, $codigo_nuevo, $request->descripcion, $request->caption, $request->estatus, $request->web, $request->link, $menu, $codigo);

        return redirect()->route('seguridad::menus::submenus::lista', ['menu' => $menu])->with('success', 'El submenú ha sido modificado correctamente.');
    }
}
