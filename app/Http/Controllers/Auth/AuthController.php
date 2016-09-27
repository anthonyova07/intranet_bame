<?php

namespace Bame\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Bame\Models\Security\Access;
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
            $lb = ldap_bind($lc, 'bancamerica\\' . $request->user, $request->password);

            $request->session()->put('user', $request->user);

            $menus = Access::getUserAccess(clear_str($request->user));

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
            return back()->with('error', 'Usuario y Contraseña incorrectos: ' . $e->getMessage());
        }
    }

    public function getLogout(Request $request) {
        do_log('Cerro sesión');
        $request->session()->flush();
        return redirect()->route('home');
    }
}
