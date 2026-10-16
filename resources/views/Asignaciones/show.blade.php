@extends('Layouts.Admin')

@section('title', 'Préstamo de equipo - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Préstamo de equipo',
        'volver' => ['url' => route('asignaciones.index'), 'texto' => 'Volver a préstamos'],
        'boton' => ['url' => route('asignaciones.edit', data_get($asignacion, 'id')), 'texto' => 'Editar', 'icono' => 'fa-pen'],
        'eliminar' => route('asignaciones.destroy', data_get($asignacion, 'id')),
    ])

    <div class="space-y-6">
        <div class="tarjeta">
            @include('Includes.cabecera-detalle', [
                'icono' => 'fa-right-left',
                'subtitulo' => 'Préstamo #' . data_get($asignacion, 'id'),
                'titulo' => data_get($asignacion, 'equipment.name', 'Equipo'),
                'extra' => view('Includes.estado', ['valor' => data_get($asignacion, 'Estado')])->render(),
            ])
            <div class="grid gap-x-8 gap-y-6 p-6 sm:grid-cols-2 sm:p-8 lg:grid-cols-3">
                @include('Includes.dato', ['etiqueta' => 'Aprendiz', 'valor' => Vista::nombre(data_get($asignacion, 'apprentice.user'), ''), 'icono' => 'fa-user-graduate'])
                @include('Includes.dato', ['etiqueta' => 'Ficha', 'valor' => data_get($asignacion, 'apprentice.coursegroup.codigo'), 'icono' => 'fa-users-rectangle'])
                @include('Includes.dato', ['etiqueta' => 'Programa', 'valor' => data_get($asignacion, 'apprentice.coursegroup.program.nombre'), 'icono' => 'fa-graduation-cap'])
                @include('Includes.dato', ['etiqueta' => 'Ambiente', 'valor' => data_get($asignacion, 'equipment.environment.nombre'), 'icono' => 'fa-door-open'])
                @include('Includes.dato', ['etiqueta' => 'Prestado el', 'valor' => Vista::fechaCorta(data_get($asignacion, 'fecha_asignacion')), 'icono' => 'fa-calendar'])
                @include('Includes.dato', ['etiqueta' => 'Devolución', 'valor' => Vista::fechaCorta(data_get($asignacion, 'fecha_devolucion'), 'Pendiente'), 'icono' => 'fa-calendar-check'])
            </div>
        </div>

    </div>
@endsection
