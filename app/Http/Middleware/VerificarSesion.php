<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Exige que exista un token de la API en la sesión (se guarda al iniciar
 * sesión contra /auth/login de AdminSena).
 */
class VerificarSesion
{
    public function handle(Request $request, Closure $next)
    {
        if (! session('api_token')) {
            return redirect()->route('login')->with('error', 'Inicia sesión para continuar.');
        }

        return $next($request);
    }
}
