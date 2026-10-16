@extends('Layouts.Admin')

@section('title', 'Fichas - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Fichas',
        'descripcion' => 'Grupos de aprendices de un programa, con su instructor líder.',
        'boton' => ['url' => route('fichas.create'), 'texto' => 'Nueva ficha'],
    ])

    @php $lista = collect($fichas ?? []); @endphp
    <div class="mb-6 grid gap-px overflow-hidden rounded-xl border border-linea bg-linea sm:grid-cols-3">
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-sena-500"></span>
            <div>
                <p class="cifra-valor">{{ count($lista) }}</p>
                <p class="cifra-texto">Fichas</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-azul-700"></span>
            <div>
                <p class="cifra-valor">{{ $lista->sum('capacidad_aprendices') }}</p>
                <p class="cifra-texto">Cupos totales</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-oro-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->pluck('program_id')->unique()->count() }}</p>
                <p class="cifra-texto">Programas con fichas</p>
            </div>
        </div>
    </div>

    <div class="tarjeta overflow-hidden">
        @include('Includes.barra-busqueda', [
            'titulo' => 'Fichas registradas',
            'placeholder' => 'Buscar por código o programa',
            'total' => count($fichas ?? []),
        ])

        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-sm">
                <thead>
                    <tr>
                            <th class="th">Ficha</th>
                            <th class="th">Capacidad</th>
                            <th class="th">Creada</th>
                            <th class="th w-px text-right"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-linea">
                    @forelse (($fichas ?? []) as $ficha)
                            <tr data-fila class="fila">
                                <td class="td"><div class="flex items-center gap-3">
                                        <span class="avatar h-10 w-10"><i class="fa-solid fa-users-rectangle text-sm"></i></span>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-azul-900">{{ data_get($ficha, 'codigo', 'Sin código') }}</p>
                                            <p class="mt-0.5 truncate text-xs text-slate-500">{{ data_get($ficha, 'program.nombre', 'Sin programa') }}</p>
                                        </div>
                                    </div></td>
                                <td class="td whitespace-nowrap text-slate-600"><i class="fa-solid fa-user-graduate mr-2 text-xs text-slate-400"></i>{{ data_get($ficha, 'capacidad_aprendices', 0) }} aprendices</td>
                                <td class="td whitespace-nowrap text-slate-500">{{ Vista::fechaCorta(data_get($ficha, 'created_at')) }}</td>
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => route('fichas.show', data_get($ficha, 'id')),
                                        'editar' => route('fichas.edit', data_get($ficha, 'id')),
                                        'eliminar' => route('fichas.destroy', data_get($ficha, 'id')),
                                        'confirmar' => '¿Eliminar esta ficha?',
                                    ])
                                </td>
                            </tr>
                    @empty
                        @include('Includes.fila-vacia', [
                            'columnas' => 4,
                            'icono' => 'fa-users-rectangle',
                            'mensaje' => 'Aún no hay fichas',
                            'boton' => ['url' => route('fichas.create'), 'texto' => 'Nueva ficha'],
                        ])
                    @endforelse
                    @include('Includes.sin-resultados', ['columnas' => 4])
                </tbody>
            </table>
        </div>
    </div>
@endsection
