<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProgramasController extends Controller
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
        $programas = $this->fetch($url . '/programas');
        return view('Programas.index', compact('programas'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $programa = $this->fetch($url . '/programas/' . $id);
        return view('Programas.show', compact('programa'));
    }
    public function create()
    {
        $url = env('URL_API');
        $areas = $this->fetch($url . '/areas');
        return view('Programas.create', compact('areas'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/programas', $request->all());
        return redirect()->route('programas.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $programa = $this->fetch($url . '/programas/' . $id);
        $areas = $this->fetch($url . '/areas');
        return view('Programas.edit', compact('programa', 'areas'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/programas/' . $id, $request->all());
        return redirect()->route('programas.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/programas/' . $id);
        return redirect()->route('programas.index');
    }
}
