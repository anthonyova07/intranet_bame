<?php

namespace Bame\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Bame\Models\Security\Access;
use Bame\Http\Requests\AuthRequest;
use Bame\Http\Controllers\Controller;
use Bame\Models\HumanResource\Employee\Employee;

use Auth;

class AuthController extends Controller
{
    public function getLogin(Request $request) {
        return view('auth.login');
    }

    public function postLogin(AuthRequest $request) {

        try {

            if (Auth::attempt(['username' => $request->user, 'password' => $request->password])) {
                session()->put('user', strtolower($request->user));

                $employee = Employee::byUser()->first();

                if (!$employee) {
                    session()->forget('user');

                    return back()->with('error', 'Usted no se encuentra registrado como empleado en la Intranet. Favor contactar a RRHH.');
                }

                session()->put('user_info', Auth::user()->getAdLDAP());
                session()->put('employee', $employee);

                $menus = Access::getUserAccess(clear_str($request->user));

                if ($menus) {
                    session()->put('menus', $menus);
                }

                do_log('Inicio sesión');

                $url_anterior = session()->get('url_anterior');

                session()->forget('url_anterior');

                $temp_auth = cookie('temp_auth', true, 1);

                if (!$url_anterior) {
                    return redirect()->route('home')->withCookie($temp_auth);
                }

                return redirect($url_anterior)->withCookie($temp_auth);
            }

            return back()->with('error', 'Usuario y Contraseña incorrectos!');

        } catch (\Throwable $e) {
            return back()->with('error', 'Usuario y Contraseña incorrectos!');
        }

    }

    public function getLogout(Request $request) {
        if (session()->has('user')) {
            do_log('Cerro sesión');
        }

        session()->flush();

        Auth::logout();
        return redirect()->route('home');
    }
}
