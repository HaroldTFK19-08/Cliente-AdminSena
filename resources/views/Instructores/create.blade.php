@extends('Layouts.Admin')

@section('title', 'Registrar instructor - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Registrar instructor',
            'descripcion' => 'Se crea el usuario y su perfil de instructor.',
            'volver' => ['url' => route('instructores.index'), 'texto' => 'Volver a instructores'],
        ])

        <form action="{{ route('instructores.store') }}" method="POST" enctype="multipart/form-data" class="tarjeta">
            @csrf
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-chalkboard-user text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Instructores._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('instructores.index'), 'texto' => 'Registrar instructor'])
            </div>
        </form>
    </div>
@endsection
