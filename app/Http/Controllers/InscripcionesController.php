<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InscripcionesController extends Controller
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
        $inscripciones = $this->fetch($url . '/inscripciones');
        return view('Inscripciones.index', compact('inscripciones'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $inscripcion = $this->fetch($url . '/inscripciones/' . $id);
        return view('Inscripciones.show', compact('inscripcion'));
    }
    public function create()
    {
        $url = env('URL_API');
        $aspirantes = $this->fetch($url . '/aspirantes');
        $ofertas = $this->fetch($url . '/ofertas');
        return view('Inscripciones.create', compact('aspirantes', 'ofertas'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/inscripciones', $request->all());
        return redirect()->route('inscripciones.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $inscripcion = $this->fetch($url . '/inscripciones/' . $id);
        $aspirantes = $this->fetch($url . '/aspirantes');
        $ofertas = $this->fetch($url . '/ofertas');
        return view('Inscripciones.edit', compact('inscripcion', 'aspirantes', 'ofertas'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/inscripciones/' . $id, $request->all());
        return redirect()->route('inscripciones.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/inscripciones/' . $id);
        return redirect()->route('inscripciones.index');
    }
}
