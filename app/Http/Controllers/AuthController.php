<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    //
    public function inicio()
    {
        if (session('api_token')) {
            return redirect()->route('home');
        }
        return view('Auth.inicio');
    }
    public function login(Request $request)
    {
        $url = env('URL_API');
        $response = Http::post($url . '/auth/login', $request->all());
        $datos = $response->json();

        // La API devuelve { user, token } cuando las credenciales son correctas
        if (! isset($datos['token'])) {
            return back()->with('error', 'El correo o la contraseña no son correctos.')->withInput($request->only('email'));
        }

        $request->session()->regenerate();
        session(['api_token' => $datos['token'], 'usuario' => $datos['user']]);
        return redirect()->route('home');
    }
    public function registro()
    {
        if (session('api_token')) {
            return redirect()->route('home');
        }
        return view('Auth.registro');
    }
    public function registrar(Request $request)
    {
        $url = env('URL_API');
        if ($request->hasFile('foto_perfil')) {
            $archivo = $request->file('foto_perfil');
            $response = Http::attach('foto_perfil', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/auth/register', $request->except('foto_perfil'));
        } else {
            $response = Http::post($url . '/auth/register', $request->all());
        }
        $datos = $response->json();

        // Si la cuenta se creó, la API también devuelve { user, token }
        if (! isset($datos['token'])) {
            return back()->with('error', 'No se pudo crear la cuenta. Revisa los datos e inténtalo de nuevo.')
                ->withInput($request->except('password', 'password_confirmation', 'foto_perfil'));
        }

        $request->session()->regenerate();
        session(['api_token' => $datos['token'], 'usuario' => $datos['user']]);
        return redirect()->route('home');
    }
    public function logout(Request $request)
    {
        $request->session()->forget(['api_token', 'usuario']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
