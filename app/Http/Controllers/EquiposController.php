<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EquiposController extends Controller
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
        $equipos = $this->fetch($url . '/equipos');
        return view('Equipos.index', compact('equipos'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $equipo = $this->fetch($url . '/equipos/' . $id);
        return view('Equipos.show', compact('equipo'));
    }
    public function create()
    {
        $url = env('URL_API');
        $ambientes = $this->fetch($url . '/ambientes');
        return view('Equipos.create', compact('ambientes'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/equipos', $request->all());
        return redirect()->route('equipos.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $equipo = $this->fetch($url . '/equipos/' . $id);
        $ambientes = $this->fetch($url . '/ambientes');
        return view('Equipos.edit', compact('equipo', 'ambientes'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/equipos/' . $id, $request->all());
        return redirect()->route('equipos.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/equipos/' . $id);
        return redirect()->route('equipos.index');
    }
}
