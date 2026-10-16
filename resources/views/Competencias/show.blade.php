@extends('Layouts.Admin')

@section('title', 'Competencia - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Competencia',
        'volver' => ['url' => route('competencias.index'), 'texto' => 'Volver a competencias'],
        'boton' => ['url' => route('competencias.edit', data_get($competencia, 'id')), 'texto' => 'Editar', 'icono' => 'fa-pen'],
        'eliminar' => route('competencias.destroy', data_get($competencia, 'id')),
    ])

    <div class="space-y-6">
        <div class="tarjeta">
            @include('Includes.cabecera-detalle', [
                'icono' => 'fa-book-open',
                'subtitulo' => data_get($competencia, 'codigo') ? 'Código ' . data_get($competencia, 'codigo') : 'Competencia',
                'titulo' => data_get($competencia, 'nombre'),
            ])
            <div class="grid gap-x-8 gap-y-6 p-6 sm:grid-cols-2 sm:p-8 lg:grid-cols-3">
                @include('Includes.dato', ['etiqueta' => 'Instructor líder', 'valor' => Vista::nombre(data_get($competencia, 'teacher.user'), ''), 'icono' => 'fa-chalkboard-user'])
                @include('Includes.dato', ['etiqueta' => 'Inicia', 'valor' => Vista::fechaCorta(data_get($competencia, 'fecha_inicio')), 'icono' => 'fa-calendar-day'])
                @include('Includes.dato', ['etiqueta' => 'Termina', 'valor' => Vista::fechaCorta(data_get($competencia, 'fecha_fin')), 'icono' => 'fa-calendar-check'])
                @include('Includes.dato', ['etiqueta' => 'Descripción', 'valor' => data_get($competencia, 'descripcion'), 'icono' => 'fa-align-left', 'ancho' => 'sm:col-span-2 lg:col-span-3'])
            </div>
        </div>
        <div class="grid gap-6 lg:grid-cols-2">
            @include('Includes.lista-relacionada', ['titulo' => 'Instructores', 'icono' => 'fa-chalkboard-user', 'items' => collect(data_get($competencia, 'teachers', []))->map(fn($t) => ['id' => data_get($t, 'id'), 'nombre' => Vista::nombre(data_get($t, 'user'))])->all(), 'campo' => 'nombre', 'vacio' => 'Sin instructores asignados.'])
            @include('Includes.lista-relacionada', ['titulo' => 'Resultados de aprendizaje', 'icono' => 'fa-list-check', 'items' => data_get($competencia, 'results', []), 'campo' => 'nombre', 'ruta' => 'resultados.show', 'vacio' => 'Aún no tiene resultados de aprendizaje.'])
        </div>
    </div>
@endsection
