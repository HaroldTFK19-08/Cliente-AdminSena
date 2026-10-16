@extends('Layouts.Admin')

@section('title', 'Calificaciones - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Calificaciones',
        'descripcion' => 'Estado de cada resultado de aprendizaje por aprendiz.',
        'boton' => ['url' => route('calificaciones.create'), 'texto' => 'Nueva calificación'],
    ])

    @php $lista = collect($calificaciones ?? []); @endphp
    <div class="mb-6 grid gap-px overflow-hidden rounded-xl border border-linea bg-linea sm:grid-cols-3">
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-sena-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('estado_resultado', 'Aprobado')->count() }}</p>
                <p class="cifra-texto">Aprobados</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-oro-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('estado_resultado', 'Pendiente')->count() }}</p>
                <p class="cifra-texto">Pendientes</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-red-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('estado_resultado', 'Reprobado')->count() }}</p>
                <p class="cifra-texto">Reprobados</p>
            </div>
        </div>
    </div>

    <div class="tarjeta overflow-hidden">
        @include('Includes.barra-busqueda', [
            'titulo' => 'Calificaciones registradas',
            'placeholder' => 'Buscar por aprendiz, resultado o estado',
            'total' => count($calificaciones ?? []),
        ])

        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-sm">
                <thead>
                    <tr>
                            <th class="th">Aprendiz</th>
                            <th class="th">Resultado</th>
                            <th class="th">Estado</th>
                            <th class="th">Calificó</th>
                            <th class="th w-px text-right"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-linea">
                    @forelse (($calificaciones ?? []) as $calificacion)
                            <tr data-fila class="fila">
                                <td class="td"><div class="flex items-center gap-3">
                                        <span class="avatar h-10 w-10"><i class="fa-solid fa-user-graduate text-sm"></i></span>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-azul-900">{{ Vista::nombre(data_get($calificacion, 'apprentice.user')) }}</p>
                                            <p class="mt-0.5 truncate text-xs text-slate-500">{{ data_get($calificacion, 'apprentice.user.identificacion') }}</p>
                                        </div>
                                    </div></td>
                                <td class="td"><p class="text-tinta">{{ data_get($calificacion, 'result.nombre') }}</p><p class="mt-0.5 text-xs text-slate-500">{{ data_get($calificacion, 'result.competition.nombre') }}</p></td>
                                <td class="td">@include('Includes.estado', ['valor' => data_get($calificacion, 'estado_resultado')])</td>
                                <td class="td text-slate-600">{{ Vista::nombre(data_get($calificacion, 'teacher.user'), '—') }}</td>
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => route('calificaciones.show', data_get($calificacion, 'id')),
                                        'editar' => route('calificaciones.edit', data_get($calificacion, 'id')),
                                        'eliminar' => route('calificaciones.destroy', data_get($calificacion, 'id')),
                                        'confirmar' => '¿Eliminar esta calificación?',
                                    ])
                                </td>
                            </tr>
                    @empty
                        @include('Includes.fila-vacia', [
                            'columnas' => 5,
                            'icono' => 'fa-clipboard-check',
                            'mensaje' => 'Aún no hay calificaciones',
                            'boton' => ['url' => route('calificaciones.create'), 'texto' => 'Nueva calificación'],
                        ])
                    @endforelse
                    @include('Includes.sin-resultados', ['columnas' => 5])
                </tbody>
            </table>
        </div>
    </div>
@endsection
