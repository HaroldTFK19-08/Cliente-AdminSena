<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AreasController extends Controller
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
        $areas = $this->fetch($url . '/areas');
        return view('Areas.index', compact('areas'));
    }
    public function show(int $id)
    {
        $url = env('URL_API');
        $area = $this->fetch($url . '/areas/' . $id);
        return view('Areas.show', compact('area'));
    }
    public function create()
    {
        $url = env('URL_API');
        $centros = $this->fetch($url . '/centros');
        return view('Areas.create', compact('centros'));
    }
    public function store(Request $request)
    {
        $url = env('URL_API');
        Http::post($url . '/areas', $request->all());
        return redirect()->route('areas.index');
    }
    public function edit(int $id)
    {
        $url = env('URL_API');
        $area = $this->fetch($url . '/areas/' . $id);
        $centros = $this->fetch($url . '/centros');
        return view('Areas.edit', compact('area', 'centros'));
    }
    public function update(Request $request, int $id)
    {
        $url = env('URL_API');
        Http::put($url . '/areas/' . $id, $request->all());
        return redirect()->route('areas.index');
    }
    public function destroy(int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/areas/' . $id);
        return redirect()->route('areas.index');
    }
}
