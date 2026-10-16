@extends('Layouts.Admin')

@section('title', 'Nueva inscripción - AdminSena')

@section('contenido')
    <div class="mx-auto max-w-3xl">
        @include('Includes.encabezado', [
            'titulo' => 'Nueva inscripción',
            'descripcion' => 'Inscribe a un aspirante en una oferta de formación.',
            'volver' => ['url' => route('inscripciones.index'), 'texto' => 'Volver a inscripciones'],
        ])

        <form action="{{ route('inscripciones.store') }}" method="POST" class="tarjeta" novalidate>
            @csrf
            <div class="flex items-center gap-3 border-b border-linea px-6 py-4 sm:px-8">
                <span class="avatar h-9 w-9"><i class="fa-solid fa-file-signature text-sm"></i></span>
                <p class="text-sm text-slate-500">Los campos con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
            <div class="space-y-6 p-6 sm:p-8">
                @include('Includes.errores')
                @include('Inscripciones._formulario')
                @include('Includes.pie-formulario', ['cancelar' => route('inscripciones.index'), 'texto' => 'Guardar inscripción'])
            </div>
        </form>
    </div>
@endsection
