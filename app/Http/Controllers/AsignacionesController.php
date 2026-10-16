<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AsignacionesController extends Controller
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
        $asignaciones = $this->fetch($url . '/asignaciones');
        return view('Asignaciones.index', compact('asignaciones'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $asignacion = $this->fetch($url . '/asignaciones/' . $id);
        return view('Asignaciones.show', compact('asignacion'));
    }
    public function create()
    {
        $url = env('URL_API');
        $equipos = $this->fetch($url . '/equipos');
        $aprendices = $this->fetch($url . '/aprendices');
        return view('Asignaciones.create', compact('equipos', 'aprendices'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/asignaciones', $request->all());
        return redirect()->route('asignaciones.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $asignacion = $this->fetch($url . '/asignaciones/' . $id);
        $equipos = $this->fetch($url . '/equipos');
        $aprendices = $this->fetch($url . '/aprendices');
        return view('Asignaciones.edit', compact('asignacion', 'equipos', 'aprendices'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/asignaciones/' . $id, $request->all());
        return redirect()->route('asignaciones.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/asignaciones/' . $id);
        return redirect()->route('asignaciones.index');
    }
}
