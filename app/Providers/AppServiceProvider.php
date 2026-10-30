<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Todas las peticiones a la API de AdminSena (Http::get, post, put, delete)
        // piden la respuesta en JSON y, si hay sesión iniciada, envían el token.
        // Así los controladores siguen con su patrón normal y el admin queda
        // autenticado ante la API (las rutas del admin exigen el token).
        Http::globalRequestMiddleware(function ($request) {
            $request = $request->withHeader('Accept', 'application/json');
            $token = session('api_token');

            return $token
                ? $request->withHeader('Authorization', 'Bearer ' . $token)
                : $request;
        });
    }
}
