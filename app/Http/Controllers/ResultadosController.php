<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ResultadosController extends Controller
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
        $resultados = $this->fetch($url . '/resultados');
        return view('Resultados.index', compact('resultados'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $resultado = $this->fetch($url . '/resultados/' . $id);
        return view('Resultados.show', compact('resultado'));
    }
    public function create()
    {
        $url = env('URL_API');
        $competencias = $this->fetch($url . '/competencias');
        return view('Resultados.create', compact('competencias'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/resultados', $request->all());
        return redirect()->route('resultados.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $resultado = $this->fetch($url . '/resultados/' . $id);
        $competencias = $this->fetch($url . '/competencias');
        return view('Resultados.edit', compact('resultado', 'competencias'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/resultados/' . $id, $request->all());
        return redirect()->route('resultados.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/resultados/' . $id);
        return redirect()->route('resultados.index');
    }
}
