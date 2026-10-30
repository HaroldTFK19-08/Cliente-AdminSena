@extends('Layouts.Admin')

@section('title', 'Aprendices - AdminSena')

@section('contenido')
    <div class="space-y-6">
        @include('Includes.encabezado', [
            'titulo' => 'Aprendices',
            'descripcion' => 'Cada aprendiz se registra con su cuenta de usuario y su ficha.',
            'boton' => ['url' => route('aprendices.create'), 'texto' => 'Registrar aprendiz'],
        ])

        @php $lista = collect($aprendices ?? []); @endphp
        <div class="grid gap-px overflow-hidden rounded-2xl border border-linea bg-linea sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['Aprendices registrados', $lista->count(), 'bg-azul-700'],
                ['Activos', $lista->where('estado', 'Activo')->count(), 'bg-sena-500'],
                ['Certificados', $lista->where('estado', 'Certificado')->count(), 'bg-oro-500'],
                ['Retirados', $lista->where('estado', 'Retirado')->count(), 'bg-red-400'],
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
                'titulo' => 'Listado de aprendices',
                'placeholder' => 'Buscar aprendiz...',
                'total' => count($aprendices ?? []),
            ])

            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead>
                        <tr>
                            <th class="th">Aprendiz</th>
                            <th class="th">Documento</th>
                            <th class="th">Ficha</th>
                            <th class="th">Estado</th>
                            <th class="th text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-linea">
                        @forelse ($aprendices ?? [] as $aprendiz)
                            <tr data-fila class="fila">
                                <td class="td">
                                    <div class="flex items-center gap-3">
                                        <span class="avatar h-10 w-10 text-xs">
                                            @if ($foto = Vista::archivo(data_get($aprendiz, 'user.foto_perfil')))
                                                <img src="{{ $foto }}" alt="" class="h-full w-full object-cover">
                                            @else
                                                {{ Vista::iniciales(data_get($aprendiz, 'user')) }}
                                            @endif
                                        </span>
                                        <div class="min-w-0">
                                            <a href="{{ route('aprendices.show', data_get($aprendiz, 'id')) }}" class="font-semibold text-azul-900 hover:text-sena-700">{{ Vista::nombre(data_get($aprendiz, 'user')) }}</a>
                                            <p class="mt-0.5 truncate text-xs text-slate-400">{{ data_get($aprendiz, 'user.email') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="td text-slate-600">{{ data_get($aprendiz, 'user.tipo_identificacion') }} {{ data_get($aprendiz, 'user.identificacion') }}</td>
                                <td class="td">
                                    <p class="font-medium text-slate-800">{{ data_get($aprendiz, 'coursegroup.codigo', '—') }}</p>
                                    <p class="mt-0.5 text-xs text-slate-500">{{ data_get($aprendiz, 'coursegroup.program.nombre') }}</p>
                                </td>
                                <td class="td">@include('Includes.estado', ['valor' => data_get($aprendiz, 'estado')])</td>
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => route('aprendices.show', data_get($aprendiz, 'id')),
                                        'editar' => route('aprendices.edit', data_get($aprendiz, 'id')),
                                        'eliminar' => route('aprendices.destroy', data_get($aprendiz, 'id')),
                                        'confirmar' => '¿Eliminar este aprendiz? También se elimina su usuario.',
                                    ])
                                </td>
                            </tr>
                        @empty
                            @include('Includes.fila-vacia', [
                                'columnas' => 5,
                                'icono' => 'fa-user-graduate',
                                'mensaje' => 'No hay aprendices registrados',
                                'boton' => ['url' => route('aprendices.create'), 'texto' => 'Registrar aprendiz'],
                            ])
                        @endforelse
                        @include('Includes.sin-resultados', ['columnas' => 5])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
