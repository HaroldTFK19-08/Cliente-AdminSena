@extends('Layouts.Admin')

@section('title', 'Nuevo usuario - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Nuevo usuario',
            'descripcion' => 'Crea la cuenta; luego complétale el perfil según su rol.',
            'volver' => ['url' => route('usuarios.index'), 'texto' => 'Volver a usuarios'],
        ])

        <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data" class="tarjeta" novalidate>
            @csrf
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-user text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Usuarios._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('usuarios.index'), 'texto' => 'Crear usuario'])
            </div>
        </form>
    </div>
@endsection
