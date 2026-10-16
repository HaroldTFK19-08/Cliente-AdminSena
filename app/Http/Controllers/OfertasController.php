<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OfertasController extends Controller
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
        $ofertas = $this->fetch($url . '/ofertas');
        return view('Ofertas.index', compact('ofertas'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $oferta = $this->fetch($url . '/ofertas/' . $id);
        return view('Ofertas.show', compact('oferta'));
    }
    public function create()
    {
        $url = env('URL_API');
        $programas = $this->fetch($url . '/programas');
        return view('Ofertas.create', compact('programas'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        if ($request->hasFile('imagen')) {
            // Con archivo la petición se envía como multipart (attach)
            $archivo = $request->file('imagen');
            Http::attach('imagen', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/ofertas', $request->except('imagen'));
        } else {
            Http::post($url . '/ofertas', $request->all());
        }
        return redirect()->route('ofertas.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $oferta = $this->fetch($url . '/ofertas/' . $id);
        $programas = $this->fetch($url . '/programas');
        return view('Ofertas.edit', compact('oferta', 'programas'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        if ($request->hasFile('imagen')) {
            // PHP no lee archivos en PUT: se envía POST y el campo _method=PUT del formulario
            $archivo = $request->file('imagen');
            Http::attach('imagen', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/ofertas/' . $id, $request->except('imagen'));
        } else {
            Http::put($url . '/ofertas/' . $id, $request->all());
        }
        return redirect()->route('ofertas.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/ofertas/' . $id);
        return redirect()->route('ofertas.index');
    }
}
