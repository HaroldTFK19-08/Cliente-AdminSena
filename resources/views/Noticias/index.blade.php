@extends('Layouts.Admin')

@section('title', 'Noticias - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Noticias',
        'descripcion' => 'Publicaciones de los centros que aparecen en el sitio público.',
        'boton' => ['url' => route('noticias.create'), 'texto' => 'Nueva noticia'],
    ])

    @php $lista = collect($noticias ?? []); @endphp
    <div class="mb-6 grid gap-px overflow-hidden rounded-xl border border-linea bg-linea sm:grid-cols-3">
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-sena-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('estado', 'Publicado')->count() }}</p>
                <p class="cifra-texto">Publicadas</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-oro-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('estado', 'Pendiente')->count() }}</p>
                <p class="cifra-texto">Pendientes</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-azul-700"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('estado', 'Creado')->count() }}</p>
                <p class="cifra-texto">Creadas</p>
            </div>
        </div>
    </div>

    <div class="tarjeta overflow-hidden">
        @include('Includes.barra-busqueda', [
            'titulo' => 'Noticias registradas',
            'placeholder' => 'Buscar por título, categoría o centro',
            'total' => count($noticias ?? []),
        ])

        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-sm">
                <thead>
                    <tr>
                            <th class="th">Noticia</th>
                            <th class="th">Categoría</th>
                            <th class="th">Centro</th>
                            <th class="th">Estado</th>
                            <th class="th w-px text-right"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-linea">
                    @forelse (($noticias ?? []) as $noticia)
                            <tr data-fila class="fila">
                                <td class="td max-w-sm"><div class="flex items-center gap-3">
                                        @if (Vista::archivo(data_get($noticia, 'imagen')))
                                            <img src="{{ Vista::archivo(data_get($noticia, 'imagen')) }}" alt="" class="h-10 w-10 shrink-0 rounded-lg object-cover">
                                        @else
                                            <span class="avatar h-10 w-10"><i class="fa-solid fa-newspaper text-sm"></i></span>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-azul-900">{{ data_get($noticia, 'titulo') }}</p>
                                            <p class="mt-0.5 truncate text-xs text-slate-500">{{ Vista::fechaCorta(data_get($noticia, 'created_at')) }}</p>
                                        </div>
                                    </div></td>
                                <td class="td"><span class="insignia bg-azul-50 text-azul-800">{{ data_get($noticia, 'categoria', '—') }}</span></td>
                                <td class="td text-slate-600">{{ data_get($noticia, 'trainingcenter.nombre', '—') }}</td>
                                <td class="td">@include('Includes.estado', ['valor' => data_get($noticia, 'estado')])</td>
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => route('noticias.show', data_get($noticia, 'id')),
                                        'editar' => route('noticias.edit', data_get($noticia, 'id')),
                                        'eliminar' => route('noticias.destroy', data_get($noticia, 'id')),
                                        'confirmar' => '¿Eliminar esta noticia?',
                                    ])
                                </td>
                            </tr>
                    @empty
                        @include('Includes.fila-vacia', [
                            'columnas' => 5,
                            'icono' => 'fa-newspaper',
                            'mensaje' => 'Aún no hay noticias',
                            'boton' => ['url' => route('noticias.create'), 'texto' => 'Nueva noticia'],
                        ])
                    @endforelse
                    @include('Includes.sin-resultados', ['columnas' => 5])
                </tbody>
            </table>
        </div>
    </div>
@endsection
