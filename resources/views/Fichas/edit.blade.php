@extends('Layouts.Admin')

@section('title', 'Editar ficha - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Editar ficha',
            'descripcion' => 'Actualiza el programa, la capacidad o los instructores.',
            'volver' => ['url' => route('fichas.show', data_get($ficha, 'id')), 'texto' => 'Volver al detalle'],
        ])

        <form action="{{ route('fichas.update', data_get($ficha, 'id')) }}" method="POST" class="tarjeta" novalidate>
            @csrf
            @method('PUT')
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-users-rectangle text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Fichas._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('fichas.show', data_get($ficha, 'id')), 'texto' => 'Guardar cambios'])
            </div>
        </form>
    </div>
@endsection
