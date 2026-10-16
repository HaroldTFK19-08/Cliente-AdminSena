@extends('Layouts.Admin')

@section('title', 'Nueva competencia - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Nueva competencia',
            'descripcion' => 'Define la competencia, su vigencia y quién la orienta.',
            'volver' => ['url' => route('competencias.index'), 'texto' => 'Volver a competencias'],
        ])

        <form action="{{ route('competencias.store') }}" method="POST" class="tarjeta" novalidate>
            @csrf
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-book-open text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Competencias._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('competencias.index'), 'texto' => 'Guardar competencia'])
            </div>
        </form>
    </div>
@endsection
