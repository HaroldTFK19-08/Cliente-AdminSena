@extends('Layouts.Admin')

@section('title', 'Instructores - AdminSena')

@section('contenido')
    <div class="space-y-6">
        @include('Includes.encabezado', [
            'titulo' => 'Instructores',
            'descripcion' => 'Cada instructor se registra con su cuenta de usuario y su área.',
            'boton' => ['url' => route('instructores.create'), 'texto' => 'Registrar instructor'],
        ])

        @php $lista = collect($instructores ?? []); @endphp
        <div class="grid gap-px overflow-hidden rounded-2xl border border-linea bg-linea sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['Instructores registrados', $lista->count(), 'bg-azul-700'],
                ['De planta', $lista->where('tipo_instructor', 'Planta')->count(), 'bg-sena-500'],
                ['Contratistas', $lista->where('tipo_instructor', 'Contratista')->count(), 'bg-oro-500'],
                ['Áreas con instructores', $lista->pluck('area_id')->filter()->unique()->count(), 'bg-azul-900'],
            ] as [$texto, $valor, $color])
                <div class="cifra">
                    <span class="h-9 w-1 rounded-full {{ $color }}"></span>
                    <div>
                        <p class="cifra-valor">{{ $valor }}</p>
                        <p class="cifra-texto">{{ $texto }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="tarjeta overflow-hidden">
            @include('Includes.barra-busqueda', [
                'titulo' => 'Listado de instructores',
                'placeholder' => 'Buscar instructor...',
                'total' => count($instructores ?? []),
            ])

            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead>
                        <tr>
                            <th class="th">Instructor</th>
                            <th class="th">Documento</th>
                            <th class="th">Área y especialidad</th>
                            <th class="th">Tipo</th>
                            <th class="th text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-linea">
                        @forelse ($instructores ?? [] as $instructor)
                            <tr data-fila class="fila">
                                <td class="td">
                                    <div class="flex items-center gap-3">
                                        <span class="avatar h-10 w-10 text-xs">
                                            @if ($foto = Vista::archivo(data_get($instructor, 'user.foto_perfil')))
                                                <img src="{{ $foto }}" alt="" class="h-full w-full object-cover">
                                            @else
                                                {{ Vista::iniciales(data_get($instructor, 'user')) }}
                                            @endif
                                        </span>
                                        <div class="min-w-0">
                                            <a href="{{ route('instructores.show', data_get($instructor, 'id')) }}" class="font-semibold text-azul-900 hover:text-sena-700">{{ Vista::nombre(data_get($instructor, 'user')) }}</a>
                                            <p class="mt-0.5 truncate text-xs text-slate-400">{{ data_get($instructor, 'user.email') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="td text-slate-600">{{ data_get($instructor, 'user.tipo_identificacion') }} {{ data_get($instructor, 'user.identificacion') }}</td>
                                <td class="td">
                                    <p class="font-medium text-slate-800">{{ data_get($instructor, 'area.nombre', '—') }}</p>
                                    <p class="mt-0.5 text-xs text-slate-500">{{ data_get($instructor, 'especialidad') }}</p>
                                </td>
                                <td class="td">
                                    <span class="insignia {{ data_get($instructor, 'tipo_instructor') === 'Planta' ? 'bg-sena-50 text-sena-700 ring-1 ring-inset ring-sena-200' : 'bg-oro-50 text-oro-700 ring-1 ring-inset ring-oro-500/30' }}">
                                        {{ data_get($instructor, 'tipo_instructor', '—') }}
                                    </span>
                                </td>
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => route('instructores.show', data_get($instructor, 'id')),
                                        'editar' => route('instructores.edit', data_get($instructor, 'id')),
                                        'eliminar' => route('instructores.destroy', data_get($instructor, 'id')),
                                        'confirmar' => '¿Eliminar este instructor? También se elimina su usuario y las fichas donde es responsable.',
                                    ])
                                </td>
                            </tr>
                        @empty
                            @include('Includes.fila-vacia', [
                                'columnas' => 5,
                                'icono' => 'fa-chalkboard-user',
                                'mensaje' => 'No hay instructores registrados',
                                'boton' => ['url' => route('instructores.create'), 'texto' => 'Registrar instructor'],
                            ])
                        @endforelse
                        @include('Includes.sin-resultados', ['columnas' => 5])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
