<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\CentrosController;
use App\Http\Controllers\AmbientesController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\ProgramasController;
use App\Http\Controllers\FichasController;
use App\Http\Controllers\CompetenciasController;
use App\Http\Controllers\ResultadosController;
use App\Http\Controllers\CalificacionesController;
use App\Http\Controllers\OfertasController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\AsignacionesController;
use App\Http\Controllers\PerfilesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicoController;

/*
|--------------------------------------------------------------------------
| Sitio público
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicoController::class, 'inicio'])
    ->name('publico.inicio');
Route::get('/convocatorias', [PublicoController::class, 'ofertas'])
    ->name('publico.ofertas');
Route::get('/convocatorias/{id}', [PublicoController::class, 'oferta'])
    ->name('publico.oferta');
Route::get('/actualidad', [PublicoController::class, 'noticias'])
    ->name('publico.noticias');
Route::get('/actualidad/{id}', [PublicoController::class, 'noticia'])
    ->name('publico.noticia');

/*
|--------------------------------------------------------------------------
| Autenticación (consume /auth/login, /auth/register y /auth/logout de AdminSena)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'inicio'])
    ->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');
Route::get('/registro', [AuthController::class, 'registro'])
    ->name('registro');
Route::post('/registro', [AuthController::class, 'registrar'])
    ->name('registro.post');
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Home (welcome): cualquier usuario con sesión iniciada
|--------------------------------------------------------------------------
*/
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('sesion.api')
    ->name('home');

/*
|--------------------------------------------------------------------------
| Panel de administración (sesión iniciada + rol Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['sesion.api', 'rol.admin'])->group(function () {

    // Áreas
    Route::get('areas', [AreasController::class, 'index'])
        ->name('areas.index');
    // Registrar área
    Route::get('areas/registro', [AreasController::class, 'create'])
        ->name('areas.create');
    Route::post('areas/post', [AreasController::class, 'store'])
        ->name('areas.post');
    // Mostrar área
    Route::get('areas/show/{id}', [AreasController::class, 'show'])
        ->name('areas.show');
    // Editar área
    Route::get('areas/edit/{id}', [AreasController::class, 'edit'])
        ->name('areas.edit');
    // Actualizar área
    Route::put('areas/update/{id}', [AreasController::class, 'update'])
        ->name('areas.update');
    // Eliminar área
    Route::delete('areas/delete/{id}', [AreasController::class, 'destroy'])
        ->name('areas.destroy');

    // Centros
    Route::get('/centros', [CentrosController::class, 'index'])
        ->name('centros.index');
    Route::get('/centros/registro', [CentrosController::class, 'create'])
        ->name('centros.create');
    Route::post('/centros', [CentrosController::class, 'store'])
        ->name('centros.store');
    Route::get('/centros/{id}', [CentrosController::class, 'show'])
        ->name('centros.show');
    Route::get('/centros/{id}/editar', [CentrosController::class, 'edit'])
        ->name('centros.edit');
    Route::put('/centros/{id}', [CentrosController::class, 'update'])
        ->name('centros.update');
    Route::delete('/centros/{id}', [CentrosController::class, 'destroy'])
        ->name('centros.destroy');

    // Ambientes
    Route::get('/ambientes', [AmbientesController::class, 'index'])
        ->name('ambientes.index');
    Route::get('/ambientes/registro', [AmbientesController::class, 'create'])
        ->name('ambientes.create');
    Route::post('/ambientes', [AmbientesController::class, 'store'])
        ->name('ambientes.store');
    Route::get('/ambientes/{id}', [AmbientesController::class, 'show'])
        ->name('ambientes.show');
    Route::get('/ambientes/{id}/editar', [AmbientesController::class, 'edit'])
        ->name('ambientes.edit');
    Route::put('/ambientes/{id}', [AmbientesController::class, 'update'])
        ->name('ambientes.update');
    Route::delete('/ambientes/{id}', [AmbientesController::class, 'destroy'])
        ->name('ambientes.destroy');

    // Usuarios
    Route::get('/usuarios', [UsuariosController::class, 'index'])
        ->name('usuarios.index');
    Route::get('/usuarios/registro', [UsuariosController::class, 'create'])
        ->name('usuarios.create');
    Route::post('/usuarios', [UsuariosController::class, 'store'])
        ->name('usuarios.store');
    Route::get('/usuarios/{id}', [UsuariosController::class, 'show'])
        ->name('usuarios.show');
    Route::get('/usuarios/{id}/editar', [UsuariosController::class, 'edit'])
        ->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UsuariosController::class, 'update'])
        ->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuariosController::class, 'destroy'])
        ->name('usuarios.destroy');

    // Equipos
    Route::get('/equipos', [EquiposController::class, 'index'])
        ->name('equipos.index');
    Route::get('/equipos/registro', [EquiposController::class, 'create'])
        ->name('equipos.create');
    Route::post('/equipos', [EquiposController::class, 'store'])
        ->name('equipos.store');
    Route::get('/equipos/{id}', [EquiposController::class, 'show'])
        ->name('equipos.show');
    Route::get('/equipos/{id}/editar', [EquiposController::class, 'edit'])
        ->name('equipos.edit');
    Route::put('/equipos/{id}', [EquiposController::class, 'update'])
        ->name('equipos.update');
    Route::delete('/equipos/{id}', [EquiposController::class, 'destroy'])
        ->name('equipos.destroy');

    // Programas
    Route::get('/programas', [ProgramasController::class, 'index'])
        ->name('programas.index');
    Route::get('/programas/registro', [ProgramasController::class, 'create'])
        ->name('programas.create');
    Route::post('/programas', [ProgramasController::class, 'store'])
        ->name('programas.store');
    Route::get('/programas/{id}', [ProgramasController::class, 'show'])
        ->name('programas.show');
    Route::get('/programas/{id}/editar', [ProgramasController::class, 'edit'])
        ->name('programas.edit');
    Route::put('/programas/{id}', [ProgramasController::class, 'update'])
        ->name('programas.update');
    Route::delete('/programas/{id}', [ProgramasController::class, 'destroy'])
        ->name('programas.destroy');

    // Fichas
    Route::get('/fichas', [FichasController::class, 'index'])
        ->name('fichas.index');
    Route::get('/fichas/registro', [FichasController::class, 'create'])
        ->name('fichas.create');
    Route::post('/fichas', [FichasController::class, 'store'])
        ->name('fichas.store');
    Route::get('/fichas/{id}', [FichasController::class, 'show'])
        ->name('fichas.show');
    Route::get('/fichas/{id}/editar', [FichasController::class, 'edit'])
        ->name('fichas.edit');
    Route::put('/fichas/{id}', [FichasController::class, 'update'])
        ->name('fichas.update');
    Route::delete('/fichas/{id}', [FichasController::class, 'destroy'])
        ->name('fichas.destroy');

    // Competencias
    Route::get('/competencias', [CompetenciasController::class, 'index'])
        ->name('competencias.index');
    Route::get('/competencias/registro', [CompetenciasController::class, 'create'])
        ->name('competencias.create');
    Route::post('/competencias', [CompetenciasController::class, 'store'])
        ->name('competencias.store');
    Route::get('/competencias/{id}', [CompetenciasController::class, 'show'])
        ->name('competencias.show');
    Route::get('/competencias/{id}/editar', [CompetenciasController::class, 'edit'])
        ->name('competencias.edit');
    Route::put('/competencias/{id}', [CompetenciasController::class, 'update'])
        ->name('competencias.update');
    Route::delete('/competencias/{id}', [CompetenciasController::class, 'destroy'])
        ->name('competencias.destroy');
    // Resultados de aprendizaje
    Route::get('/resultados', [ResultadosController::class, 'index'])
        ->name('resultados.index');
    Route::get('/resultados/registro', [ResultadosController::class, 'create'])
        ->name('resultados.create');
    Route::post('/resultados', [ResultadosController::class, 'store'])
        ->name('resultados.store');
    Route::get('/resultados/{id}', [ResultadosController::class, 'show'])
        ->name('resultados.show');
    Route::get('/resultados/{id}/editar', [ResultadosController::class, 'edit'])
        ->name('resultados.edit');
    Route::put('/resultados/{id}', [ResultadosController::class, 'update'])
        ->name('resultados.update');
    Route::delete('/resultados/{id}', [ResultadosController::class, 'destroy'])
        ->name('resultados.destroy');
    // Calificaciones
    Route::get('/calificaciones', [CalificacionesController::class, 'index'])
        ->name('calificaciones.index');
    Route::get('/calificaciones/registro', [CalificacionesController::class, 'create'])
        ->name('calificaciones.create');
    Route::post('/calificaciones', [CalificacionesController::class, 'store'])
        ->name('calificaciones.store');
    Route::get('/calificaciones/{id}', [CalificacionesController::class, 'show'])
        ->name('calificaciones.show');
    Route::get('/calificaciones/{id}/editar', [CalificacionesController::class, 'edit'])
        ->name('calificaciones.edit');
    Route::put('/calificaciones/{id}', [CalificacionesController::class, 'update'])
        ->name('calificaciones.update');
    Route::delete('/calificaciones/{id}', [CalificacionesController::class, 'destroy'])
        ->name('calificaciones.destroy');
    // Ofertas de formación
    Route::get('/ofertas', [OfertasController::class, 'index'])
        ->name('ofertas.index');
    Route::get('/ofertas/registro', [OfertasController::class, 'create'])
        ->name('ofertas.create');
    Route::post('/ofertas', [OfertasController::class, 'store'])
        ->name('ofertas.store');
    Route::get('/ofertas/{id}', [OfertasController::class, 'show'])
        ->name('ofertas.show');
    Route::get('/ofertas/{id}/editar', [OfertasController::class, 'edit'])
        ->name('ofertas.edit');
    Route::put('/ofertas/{id}', [OfertasController::class, 'update'])
        ->name('ofertas.update');
    Route::delete('/ofertas/{id}', [OfertasController::class, 'destroy'])
        ->name('ofertas.destroy');
    // Inscripciones
    Route::get('/inscripciones', [InscripcionesController::class, 'index'])
        ->name('inscripciones.index');
    Route::get('/inscripciones/registro', [InscripcionesController::class, 'create'])
        ->name('inscripciones.create');
    Route::post('/inscripciones', [InscripcionesController::class, 'store'])
        ->name('inscripciones.store');
    Route::get('/inscripciones/{id}', [InscripcionesController::class, 'show'])
        ->name('inscripciones.show');
    Route::get('/inscripciones/{id}/editar', [InscripcionesController::class, 'edit'])
        ->name('inscripciones.edit');
    Route::put('/inscripciones/{id}', [InscripcionesController::class, 'update'])
        ->name('inscripciones.update');
    Route::delete('/inscripciones/{id}', [InscripcionesController::class, 'destroy'])
        ->name('inscripciones.destroy');
    // Noticias
    Route::get('/noticias', [NoticiasController::class, 'index'])
        ->name('noticias.index');
    Route::get('/noticias/registro', [NoticiasController::class, 'create'])
        ->name('noticias.create');
    Route::post('/noticias', [NoticiasController::class, 'store'])
        ->name('noticias.store');
    Route::get('/noticias/{id}', [NoticiasController::class, 'show'])
        ->name('noticias.show');
    Route::get('/noticias/{id}/editar', [NoticiasController::class, 'edit'])
        ->name('noticias.edit');
    Route::put('/noticias/{id}', [NoticiasController::class, 'update'])
        ->name('noticias.update');
    Route::delete('/noticias/{id}', [NoticiasController::class, 'destroy'])
        ->name('noticias.destroy');
    // Asignaciones de equipos
    Route::get('/asignaciones', [AsignacionesController::class, 'index'])
        ->name('asignaciones.index');
    Route::get('/asignaciones/registro', [AsignacionesController::class, 'create'])
        ->name('asignaciones.create');
    Route::post('/asignaciones', [AsignacionesController::class, 'store'])
        ->name('asignaciones.store');
    Route::get('/asignaciones/{id}', [AsignacionesController::class, 'show'])
        ->name('asignaciones.show');
    Route::get('/asignaciones/{id}/editar', [AsignacionesController::class, 'edit'])
        ->name('asignaciones.edit');
    Route::put('/asignaciones/{id}', [AsignacionesController::class, 'update'])
        ->name('asignaciones.update');
    Route::delete('/asignaciones/{id}', [AsignacionesController::class, 'destroy'])
        ->name('asignaciones.destroy');

    // Perfiles por rol: admins, instructores, aprendices, aspirantes
    Route::prefix('perfiles/{tipo}')
        ->where(['tipo' => 'admins|instructores|aprendices|aspirantes'])
        ->group(function () {
            Route::get('/', [PerfilesController::class, 'index'])
                ->name('perfiles.index');
            Route::get('/registro', [PerfilesController::class, 'create'])
                ->name('perfiles.create');
            Route::post('/', [PerfilesController::class, 'store'])
                ->name('perfiles.store');
            Route::get('/{id}/editar', [PerfilesController::class, 'edit'])
                ->name('perfiles.edit');
            Route::put('/{id}', [PerfilesController::class, 'update'])
                ->name('perfiles.update');
            Route::delete('/{id}', [PerfilesController::class, 'destroy'])
                ->name('perfiles.destroy');
        });
});
