<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    //
    public function fetch(string $url)
    {
        $response = Http::get($url);
        return $response->json();
    }
    public function index()
    {
        $url = env('URL_API');
        $usuario = session('usuario');

        if (data_get($usuario, 'rol') === 'Admin') {
            $usuarios = $this->fetch($url . '/usuarios');
            $fichas = $this->fetch($url . '/fichas');
            $ofertas = $this->fetch($url . '/ofertas');
            $inscripciones = $this->fetch($url . '/inscripciones');
            $equipos = $this->fetch($url . '/equipos');
            $ambientes = $this->fetch($url . '/ambientes');
            $centros = $this->fetch($url . '/centros');
            return view('welcome', compact('usuario', 'usuarios', 'fichas', 'ofertas', 'inscripciones', 'equipos', 'ambientes', 'centros'));
        }

        $usuarioApi = $this->fetch($url . '/usuarios/' . data_get($usuario, 'id'));
        $ofertas = $this->fetch($url . '/ofertas');
        return view('welcome', compact('usuario', 'usuarioApi', 'ofertas'));
    }
}
