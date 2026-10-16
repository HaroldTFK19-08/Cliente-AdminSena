@extends('Layouts.Admin')

@section('title', 'Oferta de formación - AdminSena')

@section('contenido')
    @php
        $hoy = now()->toDateString();
        $etapas = array_values(array_filter([
            ['Lanzamiento', data_get($oferta, 'fecha_lanzamiento')],
            ['Abre la convocatoria', data_get($oferta, 'fecha_convocatoria')],
            ['Cierra la convocatoria', data_get($oferta, 'fecha_fin_convocatoria')],
            ['Primera prueba', data_get($oferta, 'fecha_primera_prueba')],
            ['Segunda prueba', data_get($oferta, 'fecha_segunda_prueba')],
            ['Publicación de seleccionados', data_get($oferta, 'fecha_seleccionados')],
        ], fn($e) => filled($e[1])));
        $actual = collect($etapas)->search(fn($e) => substr($e[1], 0, 10) >= $hoy);
        $actual = $actual === false ? count($etapas) : $actual;
    @endphp

    @include('Includes.encabezado', [
        'titulo' => 'Oferta de formación',
        'volver' => ['url' => route('ofertas.index'), 'texto' => 'Volver a ofertas'],
        'boton' => ['url' => route('ofertas.edit', data_get($oferta, 'id')), 'texto' => 'Editar', 'icono' => 'fa-pen'],
        'eliminar' => route('ofertas.destroy', data_get($oferta, 'id')),
    ])

    <div class="grid gap-6 lg:grid-cols-[minmax(0,3fr)_minmax(0,2fr)]">
        <div class="tarjeta self-start">
            @include('Includes.cabecera-detalle', [
                'icono' => 'fa-bullhorn',
                'imagen' => Vista::archivo(data_get($oferta, 'imagen')),
                'subtitulo' => data_get($oferta, 'program.area.trainingcenter.nombre', 'Oferta de formación'),
                'titulo' => data_get($oferta, 'program.nombre', 'Sin programa'),
                'extra' => view('Includes.estado', ['valor' => data_get($oferta, 'publicada') ? 'Publicada' : 'Borrador'])->render(),
            ])
            <div class="grid gap-x-8 gap-y-6 p-6 sm:grid-cols-2 sm:p-8">
                @include('Includes.dato', ['etiqueta' => 'Cupos', 'valor' => (string) data_get($oferta, 'capacidad'), 'icono' => 'fa-user-group'])
                @include('Includes.dato', ['etiqueta' => 'Nivel', 'valor' => data_get($oferta, 'program.nivel_programa') === 'Tecnologo' ? 'Tecnólogo' : 'Técnico', 'icono' => 'fa-signal'])
                @include('Includes.dato', ['etiqueta' => 'Área', 'valor' => data_get($oferta, 'program.area.nombre'), 'icono' => 'fa-layer-group'])
                @include('Includes.dato', ['etiqueta' => 'Código del programa', 'valor' => data_get($oferta, 'program.codigo_programa'), 'icono' => 'fa-hashtag'])
            </div>
        </div>

        <section class="tarjeta p-6 sm:p-8">
            <h2 class="tarjeta-titulo">Cronograma</h2>
            <ol class="mt-6">
                @foreach ($etapas as $i => [$texto, $fecha])
                    @php $hecha = $i < $actual; $enCurso = $i === $actual; @endphp
                    <li class="relative flex gap-4 pb-6 last:pb-0">
                        @unless ($loop->last)
                            <span class="absolute left-[11px] top-6 h-full w-0.5 {{ $hecha ? 'bg-sena-500' : 'bg-linea' }}"></span>
                        @endunless
                        <span class="relative z-10 mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 {{ $hecha ? 'border-sena-500 bg-sena-500 text-white' : ($enCurso ? 'border-sena-500 bg-white' : 'border-linea bg-white') }}">
                            @if ($hecha)
                                <i class="fa-solid fa-check text-[10px]"></i>
                            @elseif ($enCurso)
                                <span class="h-2 w-2 rounded-full bg-sena-500"></span>
                            @endif
                        </span>
                        <div class="flex flex-1 items-baseline justify-between gap-3">
                            <span class="text-[15px] {{ $enCurso ? 'font-semibold text-azul-900' : 'text-slate-600' }}">{{ $texto }}</span>
                            <span class="whitespace-nowrap text-sm tabular-nums {{ $enCurso ? 'font-semibold text-sena-700' : 'text-slate-400' }}">{{ Vista::fechaCorta($fecha) }}</span>
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>
    </div>
@endsection
