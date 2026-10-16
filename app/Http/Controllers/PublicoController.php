<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PublicoController extends Controller
{
    //
    public function fetch(string $url)
    {
        $response = Http::get($url);
        return $response->json();
    }
    public function inicio()
    {
        $url = env('URL_API');
        $ofertas = $this->fetch($url . '/ofertas');
        $noticias = $this->fetch($url . '/noticias');
        $programas = $this->fetch($url . '/programas');
        $centros = $this->fetch($url . '/centros');
        return view('Publico.inicio', compact('ofertas', 'noticias', 'programas', 'centros'));
    }
    public function ofertas()
    {
        $url = env('URL_API');
        $ofertas = $this->fetch($url . '/ofertas');
        return view('Publico.ofertas', compact('ofertas'));
    }
    public function oferta(int $id)
    {
        $url = env('URL_API');
        $oferta = $this->fetch($url . '/ofertas/' . $id);
        $ofertas = $this->fetch($url . '/ofertas');
        return view('Publico.oferta', compact('oferta', 'ofertas'));
    }
    public function noticias()
    {
        $url = env('URL_API');
        $noticias = $this->fetch($url . '/noticias');
        return view('Publico.noticias', compact('noticias'));
    }
    public function noticia(int $id)
    {
        $url = env('URL_API');
        $noticia = $this->fetch($url . '/noticias/' . $id);
        $noticias = $this->fetch($url . '/noticias');
        return view('Publico.noticia', compact('noticia', 'noticias'));
    }
}
