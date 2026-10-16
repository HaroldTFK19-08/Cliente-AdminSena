@extends('Layouts.Admin')

@section('title', 'Editar noticia - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Editar noticia',
            'descripcion' => 'Actualiza el contenido o el estado.',
            'volver' => ['url' => route('noticias.show', data_get($noticia, 'id')), 'texto' => 'Volver al detalle'],
        ])

        <form action="{{ route('noticias.update', data_get($noticia, 'id')) }}" method="POST" enctype="multipart/form-data" class="tarjeta" novalidate>
            @csrf
            @method('PUT')
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-newspaper text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Noticias._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('noticias.show', data_get($noticia, 'id')), 'texto' => 'Guardar cambios'])
            </div>
        </form>
    </div>
@endsection
