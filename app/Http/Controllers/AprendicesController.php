<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AprendicesController extends Controller
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
        $aprendices = $this->fetch($url . '/aprendices');
        return view('Aprendices.index', compact('aprendices'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $aprendiz = $this->fetch($url . '/aprendices/' . $id);
        return view('Aprendices.show', compact('aprendiz'));
    }
    public function create()
    {
        $url = env('URL_API');
        $fichas = $this->fetch($url . '/fichas');
        return view('Aprendices.create', compact('fichas'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        if ($request->hasFile('foto_perfil')) {
            // Con archivo la petición se envía como multipart (attach)
            $archivo = $request->file('foto_perfil');
            Http::attach('foto_perfil', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/aprendices', $request->except('foto_perfil'));
        } else {
            Http::post($url . '/aprendices', $request->all());
        }
        return redirect()->route('aprendices.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $aprendiz = $this->fetch($url . '/aprendices/' . $id);
        $fichas = $this->fetch($url . '/fichas');
        return view('Aprendices.edit', compact('aprendiz', 'fichas'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        if ($request->hasFile('foto_perfil')) {
            // PHP no lee archivos en PUT: se envía POST y el campo _method=PUT del formulario
            $archivo = $request->file('foto_perfil');
            Http::attach('foto_perfil', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/aprendices/' . $id, $request->except('foto_perfil'));
        } else {
            Http::put($url . '/aprendices/' . $id, $request->all());
        }
        return redirect()->route('aprendices.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/aprendices/' . $id);
        return redirect()->route('aprendices.index');
    }
}
