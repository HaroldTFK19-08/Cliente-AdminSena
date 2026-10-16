@extends('Layouts.Admin')

@section('title', 'Nueva calificación - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Nueva calificación',
            'descripcion' => 'Califica un resultado de aprendizaje para un aprendiz.',
            'volver' => ['url' => route('calificaciones.index'), 'texto' => 'Volver a calificaciones'],
        ])

        <form action="{{ route('calificaciones.store') }}" method="POST" class="tarjeta" novalidate>
            @csrf
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-clipboard-check text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Calificaciones._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('calificaciones.index'), 'texto' => 'Guardar calificación'])
            </div>
        </form>
    </div>
@endsection
