<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Perfiles por rol: admins, instructores, aprendices y aspirantes.
 * El {tipo} de la ruta es el mismo recurso de la API (/admins, /instructores, ...).
 */
class PerfilesController extends Controller
{
    /** Datos de cada tipo de perfil para las vistas. */
    public const TIPOS = [
        'admins' => ['rol' => 'Admin', 'relacion' => 'admin', 'titulo' => 'Administradores', 'singular' => 'administrador', 'icono' => 'fa-user-tie'],
        'instructores' => ['rol' => 'Instructor', 'relacion' => 'teacher', 'titulo' => 'Instructores', 'singular' => 'instructor', 'icono' => 'fa-chalkboard-user'],
        'aprendices' => ['rol' => 'Aprendiz', 'relacion' => 'apprentice', 'titulo' => 'Aprendices', 'singular' => 'aprendiz', 'icono' => 'fa-user-graduate'],
        'aspirantes' => ['rol' => 'Aspirante', 'relacion' => 'aspirant', 'titulo' => 'Aspirantes', 'singular' => 'aspirante', 'icono' => 'fa-user-clock'],
    ];

    //
    public function fetch(string $url)
    {
        $response = Http::get($url);
        return $response->json();
    }
    public function index(string $tipo)
    {
        $url = env('URL_API');
        $config = self::TIPOS[$tipo];
        $perfiles = $this->fetch($url . '/' . $tipo);
        return view('Perfiles.index', compact('tipo', 'config', 'perfiles'));
    }
    public function create(string $tipo)
    {
        $url = env('URL_API');
        $config = self::TIPOS[$tipo];
        $usuarios = $this->fetch($url . '/usuarios');
        $areas = $this->fetch($url . '/areas');
        $fichas = $this->fetch($url . '/fichas');
        return view('Perfiles.create', compact('tipo', 'config', 'usuarios', 'areas', 'fichas'));
    }
    public function store(Request $request, string $tipo)
    {
        $url = env('URL_API');
        if ($this->traeArchivos($request)) {
            $this->conArchivos($request)->post($url . '/' . $tipo, $request->except($this->archivos()));
        } else {
            Http::post($url . '/' . $tipo, $request->all());
        }
        return redirect()->route('perfiles.index', $tipo);
    }
    public function edit(string $tipo, int $id)
    {
        $url = env('URL_API');
        $config = self::TIPOS[$tipo];
        $perfil = $this->fetch($url . '/' . $tipo . '/' . $id);
        $usuarios = $this->fetch($url . '/usuarios');
        $areas = $this->fetch($url . '/areas');
        $fichas = $this->fetch($url . '/fichas');
        return view('Perfiles.edit', compact('tipo', 'config', 'perfil', 'usuarios', 'areas', 'fichas'));
    }
    public function update(Request $request, string $tipo, int $id)
    {
        $url = env('URL_API');
        if ($this->traeArchivos($request)) {
            // PHP no lee archivos en PUT: se envía POST y el campo _method=PUT del formulario
            $this->conArchivos($request)->post($url . '/' . $tipo . '/' . $id, $request->except($this->archivos()));
        } else {
            Http::put($url . '/' . $tipo . '/' . $id, $request->all());
        }
        return redirect()->route('perfiles.index', $tipo);
    }
    public function destroy(string $tipo, int $id)
    {
        $url = env('URL_API');
        Http::delete($url . '/' . $tipo . '/' . $id);
        return redirect()->route('perfiles.index', $tipo);
    }

    /** Certificados que puede subir un aspirante. */
    private function archivos(): array
    {
        return ['certificado_eps', 'certificado_bachiller', 'certificado_icfes'];
    }
    private function traeArchivos(Request $request): bool
    {
        foreach ($this->archivos() as $campo) {
            if ($request->hasFile($campo)) {
                return true;
            }
        }
        return false;
    }
    private function conArchivos(Request $request)
    {
        $peticion = Http::asMultipart();
        foreach ($this->archivos() as $campo) {
            if ($request->hasFile($campo)) {
                $archivo = $request->file($campo);
                $peticion = $peticion->attach($campo, file_get_contents($archivo->getRealPath()), $archivo->getClientOriginalName());
            }
        }
        return $peticion;
    }
}
