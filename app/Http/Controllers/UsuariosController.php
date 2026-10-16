<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsuariosController extends Controller
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
        $usuarios = $this->fetch($url . '/usuarios');
        return view('Usuarios.index', compact('usuarios'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $usuario = $this->fetch($url . '/usuarios/' . $id);
        return view('Usuarios.show', compact('usuario'));
    }
    public function create()
    {
        return view('Usuarios.create');
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        if ($request->hasFile('foto_perfil')) {
            // Con archivo la petición se envía como multipart (attach)
            $archivo = $request->file('foto_perfil');
            Http::attach('foto_perfil', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/usuarios', $request->except('foto_perfil'));
        } else {
            Http::post($url . '/usuarios', $request->all());
        }
        return redirect()->route('usuarios.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $usuario = $this->fetch($url . '/usuarios/' . $id);
        return view('Usuarios.edit', compact('usuario'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        if ($request->hasFile('foto_perfil')) {
            // PHP no lee archivos en PUT: se envía POST y el campo _method=PUT del formulario
            $archivo = $request->file('foto_perfil');
            Http::attach('foto_perfil', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/usuarios/' . $id, $request->except('foto_perfil'));
        } else {
            Http::put($url . '/usuarios/' . $id, $request->all());
        }
        return redirect()->route('usuarios.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/usuarios/' . $id);
        return redirect()->route('usuarios.index');
    }
}
