@extends('Layouts.Admin')

@section('title', 'Préstamo de equipos - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Préstamo de equipos',
        'descripcion' => 'Equipos de los ambientes prestados a los aprendices.',
        'boton' => ['url' => route('asignaciones.create'), 'texto' => 'Prestar equipo'],
    ])

    @php $lista = collect($asignaciones ?? []); @endphp
    <div class="mb-6 grid gap-px overflow-hidden rounded-xl border border-linea bg-linea sm:grid-cols-3">
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-sena-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('Estado', 'Activo')->count() }}</p>
                <p class="cifra-texto">Préstamos activos</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-oro-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->filter(fn($a) => !data_get($a, 'fecha_devolucion'))->count() }}</p>
                <p class="cifra-texto">Sin fecha de devolución</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-azul-700"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('Estado', 'Inactivo')->count() }}</p>
                <p class="cifra-texto">Finalizados</p>
            </div>
        </div>
    </div>

    <div class="tarjeta overflow-hidden">
        @include('Includes.barra-busqueda', [
            'titulo' => 'Préstamos registrados',
            'placeholder' => 'Buscar por equipo, aprendiz o ficha',
            'total' => count($asignaciones ?? []),
        ])

        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-sm">
                <thead>
                    <tr>
                            <th class="th">Equipo</th>
                            <th class="th">Aprendiz</th>
                            <th class="th">Prestado</th>
                            <th class="th">Devolución</th>
                            <th class="th">Estado</th>
                            <th class="th w-px text-right"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-linea">
                    @forelse (($asignaciones ?? []) as $asignacion)
                            <tr data-fila class="fila">
                                <td class="td"><div class="flex items-center gap-3">
                                        <span class="avatar h-10 w-10"><i class="fa-solid fa-laptop text-sm"></i></span>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-azul-900">{{ data_get($asignacion, 'equipment.name', 'Sin equipo') }}</p>
                                            <p class="mt-0.5 truncate text-xs text-slate-500">{{ data_get($asignacion, 'equipment.environment.nombre') }}</p>
                                        </div>
                                    </div></td>
                                <td class="td"><p class="text-tinta">{{ Vista::nombre(data_get($asignacion, 'apprentice.user')) }}</p><p class="mt-0.5 text-xs text-slate-500">Ficha {{ data_get($asignacion, 'apprentice.coursegroup.codigo', '—') }}</p></td>
                                <td class="td whitespace-nowrap text-slate-500">{{ Vista::fechaCorta(data_get($asignacion, 'fecha_asignacion')) }}</td>
                                <td class="td whitespace-nowrap text-slate-500">{{ Vista::fechaCorta(data_get($asignacion, 'fecha_devolucion'), 'Pendiente') }}</td>
                                <td class="td">@include('Includes.estado', ['valor' => data_get($asignacion, 'Estado')])</td>
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => route('asignaciones.show', data_get($asignacion, 'id')),
                                        'editar' => route('asignaciones.edit', data_get($asignacion, 'id')),
                                        'eliminar' => route('asignaciones.destroy', data_get($asignacion, 'id')),
                                        'confirmar' => '¿Eliminar este préstamo?',
                                    ])
                                </td>
                            </tr>
                    @empty
                        @include('Includes.fila-vacia', [
                            'columnas' => 6,
                            'icono' => 'fa-right-left',
                            'mensaje' => 'Aún no hay equipos prestados',
                            'boton' => ['url' => route('asignaciones.create'), 'texto' => 'Prestar equipo'],
                        ])
                    @endforelse
                    @include('Includes.sin-resultados', ['columnas' => 6])
                </tbody>
            </table>
        </div>
    </div>
@endsection
