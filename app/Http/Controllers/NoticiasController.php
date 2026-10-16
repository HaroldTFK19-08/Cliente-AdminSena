<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NoticiasController extends Controller
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
        $noticias = $this->fetch($url . '/noticias');
        return view('Noticias.index', compact('noticias'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $noticia = $this->fetch($url . '/noticias/' . $id);
        return view('Noticias.show', compact('noticia'));
    }
    public function create()
    {
        $url = env('URL_API');
        $centros = $this->fetch($url . '/centros');
        return view('Noticias.create', compact('centros'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        if ($request->hasFile('imagen')) {
            // Con archivo la petición se envía como multipart (attach)
            $archivo = $request->file('imagen');
            Http::attach('imagen', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/noticias', $request->except('imagen'));
        } else {
            Http::post($url . '/noticias', $request->all());
        }
        return redirect()->route('noticias.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $noticia = $this->fetch($url . '/noticias/' . $id);
        $centros = $this->fetch($url . '/centros');
        return view('Noticias.edit', compact('noticia', 'centros'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        if ($request->hasFile('imagen')) {
            // PHP no lee archivos en PUT: se envía POST y el campo _method=PUT del formulario
            $archivo = $request->file('imagen');
            Http::attach('imagen', file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName())
                ->post($url . '/noticias/' . $id, $request->except('imagen'));
        } else {
            Http::put($url . '/noticias/' . $id, $request->all());
        }
        return redirect()->route('noticias.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/noticias/' . $id);
        return redirect()->route('noticias.index');
    }
}
