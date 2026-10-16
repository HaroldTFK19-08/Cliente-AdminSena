@extends('Layouts.Admin')

@section('title', 'Ofertas de formación - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Ofertas de formación',
        'descripcion' => 'Convocatorias que los aspirantes ven en el sitio público.',
        'boton' => ['url' => route('ofertas.create'), 'texto' => 'Nueva oferta'],
    ])

    @php $lista = collect($ofertas ?? []); @endphp
    <div class="mb-6 grid gap-px overflow-hidden rounded-xl border border-linea bg-linea sm:grid-cols-3">
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-azul-700"></span>
            <div>
                <p class="cifra-valor">{{ count($lista) }}</p>
                <p class="cifra-texto">Ofertas</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-sena-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->filter(fn($o) => data_get($o, 'publicada'))->count() }}</p>
                <p class="cifra-texto">Publicadas</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-oro-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->sum('capacidad') }}</p>
                <p class="cifra-texto">Cupos ofrecidos</p>
            </div>
        </div>
    </div>

    <div class="tarjeta overflow-hidden">
        @include('Includes.barra-busqueda', [
            'titulo' => 'Ofertas registradas',
            'placeholder' => 'Buscar por programa o centro',
            'total' => count($ofertas ?? []),
        ])

        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-sm">
                <thead>
                    <tr>
                            <th class="th">Programa</th>
                            <th class="th">Cupos</th>
                            <th class="th">Convocatoria</th>
                            <th class="th">Visibilidad</th>
                            <th class="th w-px text-right"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-linea">
                    @forelse (($ofertas ?? []) as $oferta)
                            <tr data-fila class="fila">
                                <td class="td"><div class="flex items-center gap-3">
                                        @if (Vista::archivo(data_get($oferta, 'imagen')))
                                            <img src="{{ Vista::archivo(data_get($oferta, 'imagen')) }}" alt="" class="h-10 w-10 shrink-0 rounded-lg object-cover">
                                        @else
                                            <span class="avatar h-10 w-10"><i class="fa-solid fa-bullhorn text-sm"></i></span>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-azul-900">{{ data_get($oferta, 'program.nombre', 'Sin programa') }}</p>
                                            <p class="mt-0.5 truncate text-xs text-slate-500">{{ data_get($oferta, 'program.area.trainingcenter.nombre') }}</p>
                                        </div>
                                    </div></td>
                                <td class="td text-slate-600">{{ data_get($oferta, 'capacidad', 0) }}</td>
                                <td class="td whitespace-nowrap text-slate-500">{{ Vista::fechaCorta(data_get($oferta, 'fecha_convocatoria')) }} – {{ Vista::fechaCorta(data_get($oferta, 'fecha_fin_convocatoria')) }}</td>
                                <td class="td">@include('Includes.estado', ['valor' => data_get($oferta, 'publicada') ? 'Publicada' : 'Borrador'])</td>
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => route('ofertas.show', data_get($oferta, 'id')),
                                        'editar' => route('ofertas.edit', data_get($oferta, 'id')),
                                        'eliminar' => route('ofertas.destroy', data_get($oferta, 'id')),
                                        'confirmar' => '¿Eliminar esta oferta?',
                                    ])
                                </td>
                            </tr>
                    @empty
                        @include('Includes.fila-vacia', [
                            'columnas' => 5,
                            'icono' => 'fa-bullhorn',
                            'mensaje' => 'Aún no hay ofertas de formación',
                            'boton' => ['url' => route('ofertas.create'), 'texto' => 'Nueva oferta'],
                        ])
                    @endforelse
                    @include('Includes.sin-resultados', ['columnas' => 5])
                </tbody>
            </table>
        </div>
    </div>
@endsection
