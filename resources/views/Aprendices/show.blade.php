@extends('Layouts.Admin')

@section('title', 'Detalle del aprendiz - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-4xl space-y-6">
        @include('Includes.encabezado', [
            'titulo' => 'Detalle del aprendiz',
            'volver' => ['url' => route('aprendices.index'), 'texto' => 'Volver a aprendices'],
            'boton' => ['url' => route('aprendices.edit', data_get($aprendiz, 'id')), 'texto' => 'Editar', 'icono' => 'fa-pen-to-square'],
            'eliminar' => route('aprendices.destroy', data_get($aprendiz, 'id')),
            'confirmar' => '¿Eliminar este aprendiz? También se elimina su usuario.',
        ])

        <div class="tarjeta overflow-hidden">
            @include('Includes.cabecera-detalle', [
                'icono' => 'fa-user-graduate',
                'subtitulo' => 'Aprendiz #' . data_get($aprendiz, 'id'),
                'titulo' => Vista::nombre(data_get($aprendiz, 'user')),
                'imagen' => Vista::archivo(data_get($aprendiz, 'user.foto_perfil')),
            ])

            <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                @include('Includes.dato', ['etiqueta' => 'Correo', 'valor' => data_get($aprendiz, 'user.email'), 'icono' => 'fa-envelope'])
                @include('Includes.dato', ['etiqueta' => 'Documento', 'valor' => data_get($aprendiz, 'user.tipo_identificacion') . ' ' . data_get($aprendiz, 'user.identificacion'), 'icono' => 'fa-id-card'])
                @include('Includes.dato', ['etiqueta' => 'Ficha', 'valor' => data_get($aprendiz, 'coursegroup.codigo'), 'icono' => 'fa-users-rectangle'])
                @include('Includes.dato', ['etiqueta' => 'Programa', 'valor' => data_get($aprendiz, 'coursegroup.program.nombre'), 'icono' => 'fa-graduation-cap'])
                @include('Includes.dato', ['etiqueta' => 'Estado', 'valor' => data_get($aprendiz, 'estado'), 'icono' => 'fa-circle-check'])
                @include('Includes.dato', ['etiqueta' => 'Fecha de inicio', 'valor' => Vista::fecha(data_get($aprendiz, 'fecha_inicio'), 'd/m/Y', ''), 'icono' => 'fa-calendar-day'])
                @include('Includes.dato', ['etiqueta' => 'Fecha de fin', 'valor' => Vista::fecha(data_get($aprendiz, 'fecha_fin'), 'd/m/Y', 'En curso'), 'icono' => 'fa-flag-checkered'])
            </div>
        </div>
    </div>
@endsection
