<?php

namespace Bame\Http\Controllers\Security;

use Bame\Http\Requests;
use Illuminate\Http\Request;
use Bame\Models\Security\Menu;
use Bame\Models\Security\Access;
use Bame\Models\Security\SubMenu;
use Bame\Http\Controllers\Controller;
use Bame\Http\Requests\Security\AccessRequest;
use Bame\Models\HumanResource\Employee\Employee;

class AccessController extends Controller
{

    public function index()
    {
        $menus = Menu::onlyWeb()->get();

        return view('security.access.index')
            ->with('menus', $menus);
    }

    public function store(AccessRequest $request)
    {
        if ($request->save == '0') {
            $submenus = SubMenu::where('sub_codmen', $request->menu)->orderBy('sub_descri')->get();
            $user_access = Access::where('acc_user', $request->user)->where('acc_codmen', $request->menu)->get();

            $name = Employee::byUser($request->user)->first()->name;

            return back()
                ->with('submenus', $submenus)
                ->with('name', $name)
                ->with('user_access', $user_access)
                ->with('info', 'Ahora seleccione los submenús.')
                ->withInput();
        }

        Access::where('acc_user', $request->user)->where('acc_codmen', $request->menu)->delete();

        $access = [];

        if ($request->submenu) {
            foreach ($request->submenu as $index => $value) {
                array_push($access, [
                    'acc_user' => $request->user,
                    'acc_codmen' => $request->menu,
                    'acc_submen' => $value,
                    'acc_estado' => 'A',
                ]);
            }

            do_log('Concedió el acceso a ( usuario:' . $request->user . ' menu:' . $request->menu . ' submenu:' . implode(',', $request->submenu) . ' )');
        } else {
            do_log('Removió los accesos de ( usuario:' . $request->user . ' menu:' . $request->menu . ')');
        }

        Access::insert($access);

        return back()->with('success', 'Los cambios han sido guardados correctamente.');
    }
}
