<?php

namespace Bame\Http\Controllers\Security;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Security\Menu;
use Bame\Http\Requests\Security\MenuRequest;

class MenuController extends Controller
{

    public function index()
    {
        $menus = Menu::orderBy('men_descri')->paginate();

        return view('security.menu.index')
            ->with('menus', $menus);
    }

    public function create()
    {
        return view('security.menu.create');
    }

    public function store(MenuRequest $request)
    {
        $last_menu = Menu::orderBy('men_codigo', 'desc')->first();

        $menu = new Menu;

        $menu->men_banco = 1;
        $menu->men_codigo = $last_menu ? $last_menu->men_codigo + 1 : 1;
        $menu->men_descri = $request->description;
        $menu->men_estatu = get_status($request->status);
        $menu->men_web = get_web($request->web);

        $menu->save();

        do_log('Creó el Menú ( descripción:' . cap_str($request->descripción) . ' estatus:' . get_status($request->status) . ' web:' . get_web($request->web) . ' )');

        return redirect(route('security.menu.index'))->with('success', 'El menú fue creado correctamente.');
    }

    public function show($id)
    {
        return redirect(route('security.menu.index'));
    }

    public function edit($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return back()->with('warning', 'Este menú no existe!');
        }

        return view('security.menu.edit')
            ->with('menu', $menu);
    }

    public function update(MenuRequest $request, $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return back()->with('warning', 'Este menú no existe!');
        }

        $menu->men_descri = $request->description;
        $menu->men_estatu = get_status($request->status);
        $menu->men_web = get_web($request->web);

        $menu->save();

        do_log('Editó el Menú ( descripción:' . cap_str($request->description) . ' estatus:' . get_status($request->status) . ' web:' . get_web($request->web) . ' )');

        return redirect(route('security.menu.index'))->with('success', 'El menú fue editado correctamente.');
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return back()->with('warning', 'Este menú no existe!');
        }

        $menu->delete();

        do_log('Eliminó el Menú ( código:' . $menu->men_codigo . ' descripción:' . cap_str($menu->sub_descri) . ' estatus:' . get_status($menu->men_estatu) . ' web:' . get_web($menu->web) . ' )');

        return redirect(route('security.menu.index'))->with('success', 'El menú fue eliminado correctamente.');
    }
}
