@extends('Layouts.Admin')

@section('title', 'Calificación - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Calificación',
        'volver' => ['url' => route('calificaciones.index'), 'texto' => 'Volver a calificaciones'],
        'boton' => ['url' => route('calificaciones.edit', data_get($calificacion, 'id')), 'texto' => 'Editar', 'icono' => 'fa-pen'],
        'eliminar' => route('calificaciones.destroy', data_get($calificacion, 'id')),
    ])

    <div class="space-y-6">
        <div class="tarjeta">
            @include('Includes.cabecera-detalle', [
                'icono' => 'fa-clipboard-check',
                'subtitulo' => data_get($calificacion, 'result.nombre', 'Resultado de aprendizaje'),
                'titulo' => Vista::nombre(data_get($calificacion, 'apprentice.user')),
                'extra' => view('Includes.estado', ['valor' => data_get($calificacion, 'estado_resultado')])->render(),
            ])
            <div class="grid gap-x-8 gap-y-6 p-6 sm:grid-cols-2 sm:p-8 lg:grid-cols-3">
                @include('Includes.dato', ['etiqueta' => 'Competencia', 'valor' => data_get($calificacion, 'result.competition.nombre'), 'icono' => 'fa-book-open'])
                @include('Includes.dato', ['etiqueta' => 'Ficha', 'valor' => data_get($calificacion, 'apprentice.coursegroup.codigo'), 'icono' => 'fa-users-rectangle'])
                @include('Includes.dato', ['etiqueta' => 'Calificó', 'valor' => Vista::nombre(data_get($calificacion, 'teacher.user'), ''), 'icono' => 'fa-chalkboard-user'])
                @include('Includes.dato', ['etiqueta' => 'Documento del aprendiz', 'valor' => data_get($calificacion, 'apprentice.user.identificacion'), 'icono' => 'fa-id-card'])
                @include('Includes.dato', ['etiqueta' => 'Última actualización', 'valor' => Vista::fechaCorta(data_get($calificacion, 'updated_at')), 'icono' => 'fa-clock-rotate-left'])
                @include('Includes.dato', ['etiqueta' => 'Comentarios', 'valor' => data_get($calificacion, 'comentarios'), 'icono' => 'fa-comment', 'ancho' => 'sm:col-span-2 lg:col-span-3'])
            </div>
        </div>

    </div>
@endsection
