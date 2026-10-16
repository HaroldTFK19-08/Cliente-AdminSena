@extends('Layouts.Admin')

@section('title', 'Inscripción - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Inscripción',
        'volver' => ['url' => route('inscripciones.index'), 'texto' => 'Volver a inscripciones'],
        'boton' => ['url' => route('inscripciones.edit', data_get($inscripcion, 'id')), 'texto' => 'Editar', 'icono' => 'fa-pen'],
        'eliminar' => route('inscripciones.destroy', data_get($inscripcion, 'id')),
    ])

    <div class="space-y-6">
        <div class="tarjeta">
            @include('Includes.cabecera-detalle', [
                'icono' => 'fa-file-signature',
                'subtitulo' => data_get($inscripcion, 'offer.program.nombre', 'Inscripción'),
                'titulo' => Vista::nombre(data_get($inscripcion, 'aspirant.user')),
                'extra' => view('Includes.estado', ['valor' => data_get($inscripcion, 'estado')])->render(),
            ])
            <div class="grid gap-x-8 gap-y-6 p-6 sm:grid-cols-2 sm:p-8 lg:grid-cols-3">
                @include('Includes.dato', ['etiqueta' => 'Correo', 'valor' => data_get($inscripcion, 'aspirant.user.email'), 'icono' => 'fa-envelope'])
                @include('Includes.dato', ['etiqueta' => 'Documento', 'valor' => trim(data_get($inscripcion, 'aspirant.user.tipo_identificacion') . ' ' . data_get($inscripcion, 'aspirant.user.identificacion')), 'icono' => 'fa-id-card'])
                @include('Includes.dato', ['etiqueta' => 'EPS', 'valor' => data_get($inscripcion, 'aspirant.eps'), 'icono' => 'fa-notes-medical'])
                @include('Includes.dato', ['etiqueta' => 'Fecha de inscripción', 'valor' => Vista::fechaCorta(data_get($inscripcion, 'Fecha_inscripcion')), 'icono' => 'fa-calendar-plus'])
                @include('Includes.dato', ['etiqueta' => 'Convocatoria', 'valor' => Vista::fechaCorta(data_get($inscripcion, 'offer.fecha_convocatoria')) . ' a ' . Vista::fechaCorta(data_get($inscripcion, 'offer.fecha_fin_convocatoria')), 'icono' => 'fa-bullhorn', 'ancho' => 'sm:col-span-2'])
            </div>
        </div>

    </div>
@endsection
