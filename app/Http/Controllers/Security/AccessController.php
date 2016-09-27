<?php

namespace Bame\Http\Controllers\Security;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Security\Access;
use Bame\Models\Security\Menu;
use Bame\Models\Security\SubMenu;
use Bame\Http\Requests\Security\AccessRequest;

class AccessController extends Controller
{

    public function index()
    {
        $menus = Menu::orderBy('men_descri')->get();

        return view('security.access.index')
            ->with('menus', $menus);
    }

    public function create()
    {
        return redirect(route('security.access.index'));
    }

    public function store(AccessRequest $request)
    {
        if (!$request->submenu) {
            $submenus = SubMenu::where('sub_codmen', $request->menu)->orderBy('sub_descri')->get();

            return back()
                ->with('submenus', $submenus)
                ->with('info', 'Ahora seleccione un submenú.')
                ->withInput();
        }

        $access = Access::where('acc_user', $request->user)->where('acc_codmen', $request->menu)->where('acc_submen', $request->submenu)->first();

        $log = '';

        switch ($request->action) {
            case 'i':
                $log .= 'Deshabilitó ';

                if ($access) {
                    Access::where('acc_user', $request->user)
                        ->where('acc_codmen', $request->menu)
                        ->where('acc_submen', $request->submenu)
                        ->update([
                            'acc_estado' => 'I'
                        ]);
                }

                break;
            case 'a':
                $log .= 'Agregó ';

                if ($access) {
                    Access::where('acc_user', $request->user)
                        ->where('acc_codmen', $request->menu)
                        ->where('acc_submen', $request->submenu)
                        ->update([
                            'acc_estado' => 'A'
                        ]);
                } else {
                    $access = new Access;

                    $access->acc_user = $request->user;
                    $access->acc_codmen = $request->menu;
                    $access->acc_submen = $request->submenu;
                    $access->acc_estado = 'A';

                    $access->save();
                }

                break;
            case 'e':
                $log .= 'Eliminó ';

                if ($access) {
                    Access::where('acc_user', $request->user)
                        ->where('acc_codmen', $request->menu)
                        ->where('acc_submen', $request->submenu)
                        ->delete();
                }

                break;
        }

        do_log($log . 'el acceso a ( usuario:' . $request->user . ' menu:' . $request->menu . ' submenu:' . $request->submenu . ' )');

        return back()->with('success', 'La solicitud ha sido procesada correctamente.');
    }

    public function show($id)
    {
        return redirect(route('security.access.index'));
    }

    public function edit($id)
    {
        return redirect(route('security.access.index'));
    }

    public function update(MenuRequest $request, $id)
    {
        return redirect(route('security.access.index'));
    }

    public function destroy($id)
    {
        return redirect(route('security.access.index'));
    }
}
