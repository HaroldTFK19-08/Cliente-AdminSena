<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AmbientesController extends Controller
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
        $ambientes = $this->fetch($url . '/ambientes');
        return view('Ambientes.index', compact('ambientes'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $ambiente = $this->fetch($url . '/ambientes/' . $id);
        return view('Ambientes.show', compact('ambiente'));
    }
    public function create()
    {
        $url = env('URL_API');
        $centros = $this->fetch($url . '/centros');
        return view('Ambientes.create', compact('centros'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/ambientes', $request->all());
        return redirect()->route('ambientes.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $ambiente = $this->fetch($url . '/ambientes/' . $id);
        $centros = $this->fetch($url . '/centros');
        return view('Ambientes.edit', compact('ambiente', 'centros'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/ambientes/' . $id, $request->all());
        return redirect()->route('ambientes.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/ambientes/' . $id);
        return redirect()->route('ambientes.index');
    }
}
