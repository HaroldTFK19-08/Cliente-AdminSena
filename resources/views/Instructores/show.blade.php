@extends('Layouts.Admin')

@section('title', 'Detalle del instructor - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-4xl space-y-6">
        @include('Includes.encabezado', [
            'titulo' => 'Detalle del instructor',
            'volver' => ['url' => route('instructores.index'), 'texto' => 'Volver a instructores'],
            'boton' => ['url' => route('instructores.edit', data_get($instructor, 'id')), 'texto' => 'Editar', 'icono' => 'fa-pen-to-square'],
            'eliminar' => route('instructores.destroy', data_get($instructor, 'id')),
            'confirmar' => '¿Eliminar este instructor? También se elimina su usuario y las fichas donde es responsable.',
        ])

        <div class="tarjeta overflow-hidden">
            @include('Includes.cabecera-detalle', [
                'icono' => 'fa-chalkboard-user',
                'subtitulo' => 'Instructor #' . data_get($instructor, 'id'),
                'titulo' => Vista::nombre(data_get($instructor, 'user')),
                'imagen' => Vista::archivo(data_get($instructor, 'user.foto_perfil')),
            ])

            <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                @include('Includes.dato', ['etiqueta' => 'Correo', 'valor' => data_get($instructor, 'user.email'), 'icono' => 'fa-envelope'])
                @include('Includes.dato', ['etiqueta' => 'Documento', 'valor' => data_get($instructor, 'user.tipo_identificacion') . ' ' . data_get($instructor, 'user.identificacion'), 'icono' => 'fa-id-card'])
                @include('Includes.dato', ['etiqueta' => 'Área', 'valor' => data_get($instructor, 'area.nombre'), 'icono' => 'fa-layer-group'])
                @include('Includes.dato', ['etiqueta' => 'Especialidad', 'valor' => data_get($instructor, 'especialidad'), 'icono' => 'fa-star'])
                @include('Includes.dato', ['etiqueta' => 'Tipo de instructor', 'valor' => data_get($instructor, 'tipo_instructor'), 'icono' => 'fa-briefcase'])
                @include('Includes.dato', ['etiqueta' => 'Fecha de inicio', 'valor' => Vista::fecha(data_get($instructor, 'fecha_inicio'), 'd/m/Y', ''), 'icono' => 'fa-calendar-day'])
                @include('Includes.dato', ['etiqueta' => 'Fecha de fin', 'valor' => Vista::fecha(data_get($instructor, 'fecha_fin'), 'd/m/Y', 'Vigente'), 'icono' => 'fa-flag-checkered'])
                @include('Includes.dato', [
                    'etiqueta' => 'Fichas asignadas',
                    'valor' => collect(data_get($instructor, 'coursegroups', []))->pluck('codigo')->implode(', '),
                    'icono' => 'fa-users-rectangle',
                ])
            </div>
        </div>
    </div>
@endsection
