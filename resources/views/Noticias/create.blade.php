@extends('Layouts.Admin')

@section('title', 'Nueva noticia - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Nueva noticia',
            'descripcion' => 'Redacta la noticia y elige el centro que la publica.',
            'volver' => ['url' => route('noticias.index'), 'texto' => 'Volver a noticias'],
        ])

        <form action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data" class="tarjeta" novalidate>
            @csrf
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-newspaper text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Noticias._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('noticias.index'), 'texto' => 'Guardar noticia'])
            </div>
        </form>
    </div>
@endsection
