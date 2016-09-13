<?php

namespace Bame\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Bame\Models\Seguridad\Acceso;
use Bame\Http\Requests\AuthRequest;
use Bame\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function getLogin(Request $request) {
        return view('auth.login');
    }

    public function postLogin(AuthRequest $request) {
        try {

            $lc = ldap_connect('bancamerica.local');
            $lb = ldap_bind($lc, 'bancamerica\\' . $request->usuario, $request->clave);

            $request->session()->put('usuario', $request->usuario);

            $menus = Acceso::getAccessMenus(clear_str($request->usuario));

            if ($menus) {
                $request->session()->put('menus', $menus);
            }

            do_log('Inicio sesión');

            $url_anterior = $request->session()->get('url_anterior');
            $request->session()->forget('url_anterior');

            if (!$url_anterior) {
                return redirect()->route('home');
            }

            return redirect($url_anterior);

        } catch (\Exception $e) {
            // dd($e->getMessage());
            $request->session()->flush();
            return back()->with('error', 'Usuario y Contraseña incorrectos.');
        }
    }

    public function getLogout(Request $request) {
        do_log('Cerro sesión');
        $request->session()->flush();
        return redirect()->route('home');
    }
}
