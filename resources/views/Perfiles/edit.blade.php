@extends('Layouts.Admin')

@section('title', 'Editar ' . $config['singular'] . ' - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Editar perfil de ' . $config['singular'],
            'descripcion' => Vista::nombre(data_get($perfil, 'user')),
            'volver' => ['url' => route('perfiles.index', $tipo), 'texto' => 'Volver a ' . strtolower($config['titulo'])],
        ])

        <form action="{{ route('perfiles.update', [$tipo, data_get($perfil, 'id')]) }}" method="POST" enctype="multipart/form-data" class="tarjeta" novalidate>
            @csrf
            @method('PUT')
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid {{ $config['icono'] }} text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Perfiles._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('perfiles.index', $tipo), 'texto' => 'Guardar cambios'])
            </div>
        </form>
    </div>
@endsection
