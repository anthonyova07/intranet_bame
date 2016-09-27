<?php

namespace Bame\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!$request->session()->has('user')) {
            if (!$request->ajax()) {
                $request->session()->put('url_anterior', url()->current());
            }
            return redirect()->route('auth.login');
        }

        $request->session()->forget('url_anterior');

        return $next($request);
    }
}
