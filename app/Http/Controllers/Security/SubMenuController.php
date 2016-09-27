<?php

namespace Bame\Http\Controllers\Security;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Security\Menu;
use Bame\Models\Security\SubMenu;
use Bame\Http\Requests\Security\SubMenuRequest;

class SubMenuController extends Controller
{

    public function index($menu)
    {
        $submenus = SubMenu::where('sub_codmen', $menu)->paginate();

        return view('security.menu.submenu.index')
            ->with('submenus', $submenus);
    }

    public function create($menu)
    {
        $menus = Menu::all();

        return view('security.menu.submenu.create')
            ->with('menus', $menus);
    }

    public function store(SubMenuRequest $request, $menu)
    {
        $last_submenu = SubMenu::where('sub_codmen', $menu)->orderBy('sub_codigo', 'desc')->first();

        $submenu = new SubMenu;

        $submenu->sub_banco = 1;
        $submenu->sub_codmen = $request->menu;
        $submenu->sub_codigo = $last_submenu ? $last_submenu->sub_codigo + 1 : 1;
        $submenu->sub_descri = $request->description;
        $submenu->sub_caption = $request->caption;
        $submenu->sub_estatu = get_status($request->status);
        $submenu->sub_web = get_web($request->web);
        $submenu->sub_link = clear_str($request->link);
        $submenu->sub_coduni = $request->coduni;

        $submenu->save();

        do_log('Creó el SubMenú ( menú:' . $request->menu . ' descripción:' . cap_str($request->description) . ' caption:' . cap_str($request->caption) . ' estatus:' . get_status($request->status) . ' web:' . get_web($request->web) . ' link:' . clear_str($request->link) . ' coduni:' . $request->coduni . ' )');

        return redirect(route('security.menu.{menu}.submenu.index', [
            'menu' => $menu
        ]))->with('success', 'El submenú fue creado correctamente.');
    }

    public function show($menu, $id)
    {
        return redirect(route('security.menu.{menu}.submenu.index', [
            'menu' => $menu
        ]));
    }

    public function edit($menu, $id)
    {
        $menus = Menu::all();

        $submenu = SubMenu::where('sub_codmen', $menu)->find($id);

        if (!$submenu) {
            return back()->with('warning', 'Este submenú no existe!');
        }

        return view('security.menu.submenu.edit', [
            'menu' => $menu
        ])->with('menus', $menus)->with('submenu', $submenu);
    }

    public function update(SubMenuRequest $request, $menu, $id)
    {
        $submenu = SubMenu::where('sub_codmen', $menu)->find($id);

        if (!$submenu) {
            return back()->with('warning', 'Este submenú no existe!');
        }

        SubMenu::where('sub_codmen', $menu)
            ->where('sub_codigo', $id)
            ->update([
                'sub_codmen' => $request->menu,
                'sub_descri' => $request->description,
                'sub_caption' => $request->caption,
                'sub_estatu' => get_status($request->status),
                'sub_web' => get_web($request->web),
                'sub_link' => clear_str($request->link),
                'sub_coduni' => $request->coduni,
            ]);

        do_log('Editó el SubMenú ( menú:' . $request->menu . ' descripción:' . cap_str($request->descripcion) . ' caption:' . $request->caption . ' estatus:' . get_status($request->estatus) . ' web:' . get_web($request->web) . ' link:' . clear_str($request->link) . ' coduni:' . $request->coduni . ' )');

        return redirect(route('security.menu.{menu}.submenu.index', [
            'menu' => $menu
        ]))->with('success', 'El submenú fue editado correctamente.');
    }

    public function destroy($menu, $id)
    {
        $submenu = SubMenu::where('sub_codmen', $menu)->find($id);

        if (!$submenu) {
            return back()->with('warning', 'Este submenú no existe!');
        }

        SubMenu::where('sub_codmen', $menu)
                    ->where('sub_codigo', $id)
                    ->delete();

        do_log('Eliminó el SubMenú ( menú:' . $submenu->menu . ' descripción:' . cap_str($submenu->sub_descri) . ' caption:' . $submenu->caption . ' estatus:' . get_status($submenu->sub_estatu) . ' web:' . get_web($submenu->web) . ' link:' . clear_str($submenu->link) . ' coduni:' . $submenu->sub_coduni . ' )');

        return redirect(route('security.menu.{menu}.submenu.index', [
            'menu' => $menu
        ]))->with('success', 'El submenú fue eliminado correctamente.');
    }
}
