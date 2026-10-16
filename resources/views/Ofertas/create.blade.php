@extends('Layouts.Admin')

@section('title', 'Nueva oferta de formación - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Nueva oferta de formación',
            'descripcion' => 'Programa, cupos y cronograma de la convocatoria.',
            'volver' => ['url' => route('ofertas.index'), 'texto' => 'Volver a ofertas'],
        ])

        <form action="{{ route('ofertas.store') }}" method="POST" enctype="multipart/form-data" class="tarjeta" novalidate>
            @csrf
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-bullhorn text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Ofertas._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('ofertas.index'), 'texto' => 'Guardar oferta'])
            </div>
        </form>
    </div>
@endsection
