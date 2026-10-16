<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CalificacionesController extends Controller
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
        $calificaciones = $this->fetch($url . '/calificaciones');
        return view('Calificaciones.index', compact('calificaciones'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $calificacion = $this->fetch($url . '/calificaciones/' . $id);
        return view('Calificaciones.show', compact('calificacion'));
    }
    public function create()
    {
        $url = env('URL_API');
        $resultados = $this->fetch($url . '/resultados');
        $aprendices = $this->fetch($url . '/aprendices');
        $instructores = $this->fetch($url . '/instructores');
        return view('Calificaciones.create', compact('resultados', 'aprendices', 'instructores'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/calificaciones', $request->all());
        return redirect()->route('calificaciones.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $calificacion = $this->fetch($url . '/calificaciones/' . $id);
        $resultados = $this->fetch($url . '/resultados');
        $aprendices = $this->fetch($url . '/aprendices');
        $instructores = $this->fetch($url . '/instructores');
        return view('Calificaciones.edit', compact('calificacion', 'resultados', 'aprendices', 'instructores'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/calificaciones/' . $id, $request->all());
        return redirect()->route('calificaciones.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/calificaciones/' . $id);
        return redirect()->route('calificaciones.index');
    }
}
