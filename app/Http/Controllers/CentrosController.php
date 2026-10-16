<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CentrosController extends Controller
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
        $centros = $this->fetch($url . '/centros');
        return view('Centros.index', compact('centros'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $centro = $this->fetch($url . '/centros/' . $id);
        return view('Centros.show', compact('centro'));
    }
    public function create()
    {
        return view('Centros.create');
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/centros', $request->all());
        return redirect()->route('centros.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $centro = $this->fetch($url . '/centros/' . $id);
        return view('Centros.edit', compact('centro'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/centros/' . $id, $request->all());
        return redirect()->route('centros.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/centros/' . $id);
        return redirect()->route('centros.index');
    }
}
