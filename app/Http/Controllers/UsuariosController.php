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
        $url = env('URL_API');
        // Listas para los atributos del rol (ficha del aprendiz, área del instructor)
        $areas = $this->fetch($url . '/areas');
        $fichas = $this->fetch($url . '/fichas');
        return view('Usuarios.create', compact('areas', 'fichas'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        if ($request->hasFile('foto_perfil')) {
            // Con archivo la petición se envía como multipart (attach)
            $archivo = $request->file('foto_perfil');
            $response = Http::acceptJson()
                ->attach('foto_perfil', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/usuarios', $request->except('foto_perfil'));
        } else {
            $response = Http::acceptJson()->post($url . '/usuarios', $request->all());
        }

        if ($response->failed()) {
            $errores = $response->json('errors');
            $mensaje = $response->json('message') ?? 'No se pudo crear el usuario. Revisa los datos ingresados.';
            if (is_array($errores)) {
                $mensajes = [];
                foreach ($errores as $campo => $errs) {
                    $mensajes[] = is_array($errs) ? implode(' ', $errs) : $errs;
                }
                $mensaje = implode(' ', $mensajes);
            }
            return back()->with('error', $mensaje)->withInput();
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario registrado correctamente.');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $usuario = $this->fetch($url . '/usuarios/' . $id);
        $areas = $this->fetch($url . '/areas');
        $fichas = $this->fetch($url . '/fichas');
        return view('Usuarios.edit', compact('usuario', 'areas', 'fichas'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        if ($request->hasFile('foto_perfil')) {
            // PHP no lee archivos en PUT: se envía POST y el campo _method=PUT del formulario
            $archivo = $request->file('foto_perfil');
            $response = Http::acceptJson()
                ->attach('foto_perfil', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/usuarios/' . $id, $request->except('foto_perfil'));
        } else {
            $response = Http::acceptJson()->put($url . '/usuarios/' . $id, $request->all());
        }

        if ($response->failed()) {
            $errores = $response->json('errors');
            $mensaje = $response->json('message') ?? 'No se pudo actualizar el usuario.';
            if (is_array($errores)) {
                $mensajes = [];
                foreach ($errores as $campo => $errs) {
                    $mensajes[] = is_array($errs) ? implode(' ', $errs) : $errs;
                }
                $mensaje = implode(' ', $mensajes);
            }
            return back()->with('error', $mensaje)->withInput();
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        $response = Http::acceptJson()->delete($url . '/usuarios/' . $id);

        if ($response->failed()) {
            $mensaje = $response->json('message') ?? 'No se pudo eliminar el usuario.';
            return back()->with('error', $mensaje);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
