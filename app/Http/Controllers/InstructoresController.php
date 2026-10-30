<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstructoresController extends Controller
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
        $instructores = $this->fetch($url . '/instructores');
        return view('Instructores.index', compact('instructores'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $instructor = $this->fetch($url . '/instructores/' . $id);
        return view('Instructores.show', compact('instructor'));
    }
    public function create()
    {
        $url = env('URL_API');
        $areas = $this->fetch($url . '/areas');
        return view('Instructores.create', compact('areas'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        if ($request->hasFile('foto_perfil')) {
            // Con archivo la petición se envía como multipart (attach)
            $archivo = $request->file('foto_perfil');
            Http::attach('foto_perfil', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/instructores', $request->except('foto_perfil'));
        } else {
            Http::post($url . '/instructores', $request->all());
        }
        return redirect()->route('instructores.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $instructor = $this->fetch($url . '/instructores/' . $id);
        $areas = $this->fetch($url . '/areas');
        return view('Instructores.edit', compact('instructor', 'areas'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        if ($request->hasFile('foto_perfil')) {
            // PHP no lee archivos en PUT: se envía POST y el campo _method=PUT del formulario
            $archivo = $request->file('foto_perfil');
            Http::attach('foto_perfil', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/instructores/' . $id, $request->except('foto_perfil'));
        } else {
            Http::put($url . '/instructores/' . $id, $request->all());
        }
        return redirect()->route('instructores.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/instructores/' . $id);
        return redirect()->route('instructores.index');
    }
}
