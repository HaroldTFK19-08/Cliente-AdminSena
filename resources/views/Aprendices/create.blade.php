@extends('Layouts.Admin')

@section('title', 'Registrar aprendiz - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Registrar aprendiz',
            'descripcion' => 'Se crea el usuario y su perfil de aprendiz.',
            'volver' => ['url' => route('aprendices.index'), 'texto' => 'Volver a aprendices'],
        ])

        <form action="{{ route('aprendices.store') }}" method="POST" enctype="multipart/form-data" class="tarjeta">
            @csrf
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-user-graduate text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Aprendices._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('aprendices.index'), 'texto' => 'Registrar aprendiz'])
            </div>
        </form>
    </div>
@endsection
