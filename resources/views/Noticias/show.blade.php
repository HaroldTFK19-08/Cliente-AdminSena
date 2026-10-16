@extends('Layouts.Admin')

@section('title', 'Noticia - AdminSena')

@section('contenido')
    @php $imagen = Vista::archivo(data_get($noticia, 'imagen')); @endphp

    @include('Includes.encabezado', [
        'titulo' => 'Noticia',
        'volver' => ['url' => route('noticias.index'), 'texto' => 'Volver a noticias'],
        'boton' => ['url' => route('noticias.edit', data_get($noticia, 'id')), 'texto' => 'Editar', 'icono' => 'fa-pen'],
        'eliminar' => route('noticias.destroy', data_get($noticia, 'id')),
    ])

    <div class="grid gap-6 lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
        <article class="tarjeta overflow-hidden">
            @if ($imagen)
                <img src="{{ $imagen }}" alt="" class="aspect-[16/8] w-full object-cover">
            @endif
            <div class="p-6 sm:p-10">
                <p class="text-sm font-medium text-sena-700">{{ data_get($noticia, 'categoria') }}</p>
                <h2 class="mt-2 text-2xl font-bold leading-snug sm:text-3xl">{{ data_get($noticia, 'titulo') }}</h2>
                <div class="mt-6 max-w-prose whitespace-pre-line text-[16px] leading-[1.75] text-slate-700">{{ data_get($noticia, 'descripcion') }}</div>
            </div>
        </article>

        <aside class="tarjeta self-start p-6">
            <h3 class="tarjeta-titulo">Publicación</h3>
            <div class="mt-5 space-y-5">
                <div>
                    <p class="text-sm text-slate-500">Estado</p>
                    <div class="mt-1">@include('Includes.estado', ['valor' => data_get($noticia, 'estado')])</div>
                </div>
                <div>
                    <p class="text-sm text-slate-500">En el sitio público</p>
                    <p class="mt-1 text-[15px] font-medium text-tinta">{{ data_get($noticia, 'publicada') ? 'Visible' : 'Oculta' }}</p>
                </div>
                @include('Includes.dato', ['etiqueta' => 'Centro', 'valor' => data_get($noticia, 'trainingcenter.nombre'), 'icono' => 'fa-building-columns'])
                @include('Includes.dato', ['etiqueta' => 'Autor', 'valor' => Vista::nombre(data_get($noticia, 'admin.user'), ''), 'icono' => 'fa-user-pen'])
                @include('Includes.dato', ['etiqueta' => 'Creada', 'valor' => Vista::fechaCorta(data_get($noticia, 'created_at')), 'icono' => 'fa-calendar'])
            </div>
        </aside>
    </div>
@endsection
