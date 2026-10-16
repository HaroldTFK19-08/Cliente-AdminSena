@extends('Layouts.Admin')

@section('title', 'Editar resultado de aprendizaje - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Editar resultado de aprendizaje',
            'descripcion' => 'Actualiza los datos del resultado.',
            'volver' => ['url' => route('resultados.show', data_get($resultado, 'id')), 'texto' => 'Volver al detalle'],
        ])

        <form action="{{ route('resultados.update', data_get($resultado, 'id')) }}" method="POST" class="tarjeta" novalidate>
            @csrf
            @method('PUT')
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-list-check text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Resultados._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('resultados.show', data_get($resultado, 'id')), 'texto' => 'Guardar cambios'])
            </div>
        </form>
    </div>
@endsection
