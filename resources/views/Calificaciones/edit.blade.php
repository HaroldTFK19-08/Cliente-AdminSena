@extends('Layouts.Admin')

@section('title', 'Editar calificación - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Editar calificación',
            'descripcion' => 'Actualiza el estado o los comentarios.',
            'volver' => ['url' => route('calificaciones.show', data_get($calificacion, 'id')), 'texto' => 'Volver al detalle'],
        ])

        <form action="{{ route('calificaciones.update', data_get($calificacion, 'id')) }}" method="POST" class="tarjeta" novalidate>
            @csrf
            @method('PUT')
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-clipboard-check text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Calificaciones._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('calificaciones.show', data_get($calificacion, 'id')), 'texto' => 'Guardar cambios'])
            </div>
        </form>
    </div>
@endsection
