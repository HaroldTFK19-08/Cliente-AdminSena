<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CompetenciasController extends Controller
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
        $competencias = $this->fetch($url . '/competencias');
        return view('Competencias.index', compact('competencias'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $competencia = $this->fetch($url . '/competencias/' . $id);
        return view('Competencias.show', compact('competencia'));
    }
    public function create()
    {
        $url = env('URL_API');
        $instructores = $this->fetch($url . '/instructores');
        return view('Competencias.create', compact('instructores'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/competencias', $request->all());
        return redirect()->route('competencias.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $competencia = $this->fetch($url . '/competencias/' . $id);
        $instructores = $this->fetch($url . '/instructores');
        return view('Competencias.edit', compact('competencia', 'instructores'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/competencias/' . $id, $request->all());
        return redirect()->route('competencias.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/competencias/' . $id);
        return redirect()->route('competencias.index');
    }
}
