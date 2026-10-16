@extends('Layouts.Admin')

@section('title', 'Inscripciones - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Inscripciones',
        'descripcion' => 'Aspirantes inscritos a las ofertas de formación.',
        'boton' => ['url' => route('inscripciones.create'), 'texto' => 'Nueva inscripción'],
    ])

    @php $lista = collect($inscripciones ?? []); @endphp
    <div class="mb-6 grid gap-px overflow-hidden rounded-xl border border-linea bg-linea sm:grid-cols-2 lg:grid-cols-4">
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-oro-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('estado', 'Registrado')->count() }}</p>
                <p class="cifra-texto">Registradas</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-azul-700"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('estado', 'En proceso')->count() }}</p>
                <p class="cifra-texto">En proceso</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-sena-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->where('estado', 'Seleccionado')->count() }}</p>
                <p class="cifra-texto">Seleccionadas</p>
            </div>
        </div>
        <div class="cifra">
            <span class="h-9 w-1 rounded-full bg-red-500"></span>
            <div>
                <p class="cifra-valor">{{ $lista->whereIn('estado', ['Rechazado', 'Cancelada'])->count() }}</p>
                <p class="cifra-texto">Rechazadas o canceladas</p>
            </div>
        </div>
    </div>

    <div class="tarjeta overflow-hidden">
        @include('Includes.barra-busqueda', [
            'titulo' => 'Inscripciones registradas',
            'placeholder' => 'Buscar por aspirante, programa o estado',
            'total' => count($inscripciones ?? []),
        ])

        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-sm">
                <thead>
                    <tr>
                            <th class="th">Aspirante</th>
                            <th class="th">Programa</th>
                            <th class="th">Estado</th>
                            <th class="th">Fecha</th>
                            <th class="th w-px text-right"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-linea">
                    @forelse (($inscripciones ?? []) as $inscripcion)
                            <tr data-fila class="fila">
                                <td class="td"><div class="flex items-center gap-3">
                                        <span class="avatar h-10 w-10"><i class="fa-solid fa-user-clock text-sm"></i></span>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-azul-900">{{ Vista::nombre(data_get($inscripcion, 'aspirant.user')) }}</p>
                                            <p class="mt-0.5 truncate text-xs text-slate-500">{{ data_get($inscripcion, 'aspirant.user.email') }}</p>
                                        </div>
                                    </div></td>
                                <td class="td text-slate-600">{{ data_get($inscripcion, 'offer.program.nombre', 'Sin oferta') }}</td>
                                <td class="td">@include('Includes.estado', ['valor' => data_get($inscripcion, 'estado')])</td>
                                <td class="td whitespace-nowrap text-slate-500">{{ Vista::fechaCorta(data_get($inscripcion, 'Fecha_inscripcion')) }}</td>
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => route('inscripciones.show', data_get($inscripcion, 'id')),
                                        'editar' => route('inscripciones.edit', data_get($inscripcion, 'id')),
                                        'eliminar' => route('inscripciones.destroy', data_get($inscripcion, 'id')),
                                        'confirmar' => '¿Eliminar esta inscripción?',
                                    ])
                                </td>
                            </tr>
                    @empty
                        @include('Includes.fila-vacia', [
                            'columnas' => 5,
                            'icono' => 'fa-file-signature',
                            'mensaje' => 'Aún no hay inscripciones',
                            'boton' => ['url' => route('inscripciones.create'), 'texto' => 'Nueva inscripción'],
                        ])
                    @endforelse
                    @include('Includes.sin-resultados', ['columnas' => 5])
                </tbody>
            </table>
        </div>
    </div>
@endsection
