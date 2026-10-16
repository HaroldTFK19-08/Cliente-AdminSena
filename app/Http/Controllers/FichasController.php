<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FichasController extends Controller
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
        $fichas = $this->fetch($url . '/fichas');
        return view('Fichas.index', compact('fichas'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $ficha = $this->fetch($url . '/fichas/' . $id);
        return view('Fichas.show', compact('ficha'));
    }
    public function create()
    {
        $url = env('URL_API');
        $programas = $this->fetch($url . '/programas');
        $instructores = $this->fetch($url . '/instructores');
        return view('Fichas.create', compact('programas', 'instructores'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/fichas', $request->all());
        return redirect()->route('fichas.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $ficha = $this->fetch($url . '/fichas/' . $id);
        $programas = $this->fetch($url . '/programas');
        $instructores = $this->fetch($url . '/instructores');
        return view('Fichas.edit', compact('ficha', 'programas', 'instructores'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/fichas/' . $id, $request->all());
        return redirect()->route('fichas.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/fichas/' . $id);
        return redirect()->route('fichas.index');
    }
}
