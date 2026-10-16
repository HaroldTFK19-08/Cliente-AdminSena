@extends('Layouts.Admin')

@section('title', $config['titulo'] . ' - AdminSena')

@section('contenido')
    @php
        $tipos = \App\Http\Controllers\PerfilesController::TIPOS;

        // Columna propia de cada tipo de perfil: [encabezado, valor]
        $detalle = fn($p) => match ($tipo) {
            'admins' => [data_get($p, 'cargo'), data_get($p, 'ubicacion_oficina')],
            'instructores' => [data_get($p, 'especialidad'), trim(data_get($p, 'area.nombre') . ', ' . data_get($p, 'tipo_instructor'), ', ')],
            'aprendices' => ['Ficha ' . data_get($p, 'coursegroup.codigo', '—'), data_get($p, 'coursegroup.program.nombre')],
            'aspirantes' => ['EPS ' . data_get($p, 'eps', '—'), collect(['certificado_eps', 'certificado_bachiller', 'certificado_icfes'])->filter(fn($c) => data_get($p, $c))->count() . ' de 3 certificados'],
        };
    @endphp

    <div class="space-y-6">
        @include('Includes.encabezado', [
            'titulo' => 'Perfiles por rol',
            'descripcion' => 'Datos propios de cada rol. Primero crea el usuario y luego complétale aquí su perfil.',
            'boton' => ['url' => route('perfiles.create', $tipo), 'texto' => 'Registrar ' . $config['singular']],
        ])

        {{-- Pestañas por rol --}}
        <nav class="flex gap-1 overflow-x-auto border-b border-linea" aria-label="Tipos de perfil">
            @foreach ($tipos as $clave => $item)
                <a href="{{ route('perfiles.index', $clave) }}" @if ($clave === $tipo) aria-current="page" @endif
                    class="-mb-px inline-flex shrink-0 items-center gap-2 border-b-2 px-4 py-3 text-sm font-medium transition {{ $clave === $tipo ? 'border-sena-500 text-azul-900' : 'border-transparent text-slate-500 hover:text-azul-900' }}">
                    <i class="fa-solid {{ $item['icono'] }} text-xs {{ $clave === $tipo ? 'text-sena-500' : '' }}"></i>
                    {{ $item['titulo'] }}
                </a>
            @endforeach
        </nav>

        <div class="tarjeta overflow-hidden">
            @include('Includes.barra-busqueda', [
                'titulo' => $config['titulo'],
                'placeholder' => 'Buscar por nombre, documento o correo...',
                'total' => count($perfiles ?? []),
            ])

            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="bg-papel text-xs text-slate-500">
                        <tr>
                            <th class="th">Usuario</th>
                            <th class="th">Identificación</th>
                            <th class="th">Detalle del perfil</th>
                            @if ($tipo === 'aprendices')
                                <th class="th">Estado</th>
                            @endif
                            <th class="th text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-linea">
                        @forelse (($perfiles ?? []) as $perfil)
                            @php [$principal, $secundario] = $detalle($perfil); @endphp
                            <tr data-fila class="transition-colors hover:bg-sena-50/50">
                                <td class="td">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-azul-50 text-xs font-bold text-azul-800">
                                            {{ Vista::iniciales(data_get($perfil, 'user')) }}
                                        </span>
                                        <div>
                                            <p class="font-semibold text-azul-900">{{ Vista::nombre(data_get($perfil, 'user')) }}</p>
                                            <p class="mt-0.5 text-xs text-slate-400">{{ data_get($perfil, 'user.email') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="td text-slate-600">{{ data_get($perfil, 'user.tipo_identificacion') }} {{ data_get($perfil, 'user.identificacion') }}</td>
                                <td class="td">
                                    <p class="text-slate-800">{{ $principal ?: '—' }}</p>
                                    <p class="mt-0.5 text-xs text-slate-500">{{ $secundario }}</p>
                                </td>
                                @if ($tipo === 'aprendices')
                                    <td class="td">
                                        @include('Includes.estado', ['valor' => data_get($perfil, 'estado')])
                                    </td>
                                @endif
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => data_get($perfil, 'user_id') ? route('usuarios.show', data_get($perfil, 'user_id')) : null,
                                        'editar' => route('perfiles.edit', [$tipo, data_get($perfil, 'id')]),
                                        'eliminar' => route('perfiles.destroy', [$tipo, data_get($perfil, 'id')]),
                                        'confirmar' => '¿Seguro que deseas eliminar este perfil? El usuario no se elimina.',
                                    ])
                                </td>
                            </tr>
                        @empty
                            @include('Includes.fila-vacia', [
                                'columnas' => $tipo === 'aprendices' ? 5 : 4,
                                'icono' => $config['icono'],
                                'mensaje' => 'No hay perfiles de ' . $config['singular'],
                                'boton' => ['url' => route('perfiles.create', $tipo), 'texto' => 'Registrar ' . $config['singular']],
                            ])
                        @endforelse
                        @include('Includes.sin-resultados', ['columnas' => $tipo === 'aprendices' ? 5 : 4])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
