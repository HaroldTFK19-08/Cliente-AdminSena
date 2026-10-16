<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Solo deja pasar a los usuarios con rol Admin (rol guardado en la sesión
 * al iniciar sesión contra /auth/login de AdminSena).
 */
class EsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (data_get(session('usuario'), 'rol') !== 'Admin') {
            return redirect()->route('home')->with('error', 'Esa sección es solo para administradores.');
        }

        return $next($request);
    }
}
