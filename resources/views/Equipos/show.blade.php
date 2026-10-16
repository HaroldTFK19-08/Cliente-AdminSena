@extends('Layouts.Admin')

@section('title', 'Detalle del Equipo - AdminSena')

@section('contenido')
    @php
        $get = fn($keys, $default = '—') => collect($keys)->reduce(
            fn($carry, $key) => $carry ??
                (data_get($equipo, $key) !== null && data_get($equipo, $key) !== '' ? data_get($equipo, $key) : null),
            null,
        ) ?? $default;

        // Datos reales devueltos por la API
        $id = $get(['id'], '');
        $nombre = $get(['name', 'nombre'], 'Equipo sin nombre');
        $marca = $get(['brand', 'marca']);
        $tipo = $get(['equipment_type', 'tipo', 'tipo_equipo']);
        $ambiente = $get(['environment.nombre', 'ambiente.nombre'], 'Sin ambiente asignado');
        $creado = $get(['created_at', 'fecha_registro'], '');

        // El JSON actual no incluye un campo de estado.
        $estado = $get(['status', 'estado', 'estado_equipo'], '');

        $estadoLower = strtolower(trim((string) $estado));

        $badgeClass = match (true) {
            in_array($estadoLower, ['activo', 'active', 'operativo', 'disponible', '1', 'true'])
                => 'bg-emerald-50 text-emerald-700 ring-emerald-200',

            in_array($estadoLower, ['mantenimiento', 'en mantenimiento', 'maintenance'])
                => 'bg-amber-50 text-amber-700 ring-amber-200',

            $estadoLower === '' => 'bg-slate-100 text-slate-600 ring-slate-200',

            default => 'bg-rose-50 text-rose-600 ring-rose-200',
        };

        $estadoTexto = $estado !== '' ? ucfirst($estado) : 'No especificado';
    @endphp

    <div class="space-y-6">

        {{-- Navegación --}}
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('equipos.index') }}" class="transition hover:text-[#39A900]">
                Equipos
            </a>

            <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>

            <span class="font-medium text-gray-800">
                Detalle del equipo
            </span>
        </div>

        {{-- Encabezado --}}
        <div class="relative overflow-hidden rounded-3xl bg-[#081B28] p-6 shadow-lg sm:p-8">
            <div class="absolute -right-10 -top-16 h-48 w-48 rounded-full bg-[#39A900]/20 blur-3xl"></div>

            <div class="relative flex flex-col justify-between gap-5 sm:flex-row sm:items-start">

                <div class="flex items-center gap-5">
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#39A900] text-white shadow-lg shadow-[#39A900]/20">
                        <i class="fa-solid fa-laptop text-2xl"></i>
                    </div>

                    <div>
                        <div
                            class="mb-1.5 flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-[#90EE90]">
                            <span class="h-2 w-2 rounded-full bg-[#39A900]"></span>
                            Inventario institucional
                        </div>

                        <h1 class="text-2xl font-extrabold text-white sm:text-3xl">
                            {{ $nombre }}
                        </h1>

                        <p class="mt-1 text-sm text-slate-400">
                            {{ $marca }} · {{ $tipo }}
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <a href="{{ route('equipos.edit', $id) }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/20">
                        <i class="fa-solid fa-pen text-xs"></i>
                        Editar
                    </a>

                    <a href="{{ route('equipos.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-300 transition hover:bg-white/10">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        {{-- Datos del equipo --}}
        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Ficha principal --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm lg:col-span-2">

                <div class="border-b border-gray-100 px-6 py-4">
                    <h2 class="font-semibold text-gray-900">
                        Información del equipo
                    </h2>
                </div>

                <dl class="divide-y divide-gray-100">

                    @foreach ([['Identificador', $id, 'fa-hashtag'], ['Nombre', $nombre, 'fa-laptop'], ['Marca', $marca, 'fa-tag'], ['Tipo de equipo', $tipo, 'fa-list'], ['Ambiente asignado', $ambiente, 'fa-door-open']] as [$label, $valor, $icon])
                        <div class="flex items-start gap-4 px-6 py-4">

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                <i class="fa-solid {{ $icon }} text-sm"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    {{ $label }}
                                </dt>

                                <dd class="mt-0.5 break-words text-sm font-medium text-gray-900">
                                    {{ $valor }}
                                </dd>
                            </div>

                        </div>
                    @endforeach

                </dl>
            </div>

            {{-- Panel lateral --}}
            <div class="space-y-5">

                {{-- Estado --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h3 class="mb-3 text-sm font-semibold text-gray-700">
                        Estado actual
                    </h3>

                    <span
                        class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-bold ring-1 {{ $badgeClass }}">
                        <span
                            class="h-2 w-2 rounded-full {{ $estadoLower === '' ? 'bg-slate-400' : (str_contains($badgeClass, 'emerald') ? 'bg-emerald-500' : (str_contains($badgeClass, 'amber') ? 'bg-amber-500' : 'bg-rose-400')) }}"></span>

                        {{ $estadoTexto }}
                    </span>

                    @if ($estadoLower === '')
                        <p class="mt-3 text-xs leading-5 text-gray-500">
                            La API no proporciona un estado para este equipo.
                        </p>
                    @endif
                </div>

                {{-- Fecha de registro --}}
                @if ($creado !== '')
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <h3 class="mb-1 text-sm font-semibold text-gray-700">
                            Fecha de registro
                        </h3>

                        <p class="text-sm text-gray-500">
                            @php
                                try {
                                    echo \Illuminate\Support\Carbon::parse($creado)
                                        ->locale('es')
                                        ->translatedFormat('d \d\e F \d\e Y');
                                } catch (\Throwable $e) {
                                    echo e($creado);
                                }
                            @endphp
                        </p>
                    </div>
                @endif

                {{-- Acciones rápidas --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h3 class="mb-3 text-sm font-semibold text-gray-700">
                        Acciones
                    </h3>

                    <div class="space-y-2">

                        <a href="{{ route('equipos.edit', $id) }}"
                            class="flex w-full items-center gap-2.5 rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:border-[#39A900]/40 hover:bg-[#f0fbe8] hover:text-[#278000]">
                            <i class="fa-solid fa-pen-to-square text-sm text-[#39A900]"></i>
                            Editar equipo
                        </a>

                        <form action="{{ route('equipos.destroy', $id) }}" method="POST"
                            onsubmit="return confirm('¿Eliminar el equipo «{{ e($nombre) }}»?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="flex w-full items-center gap-2.5 rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700">
                                <i class="fa-solid fa-trash-can text-sm text-rose-500"></i>
                                Eliminar equipo
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
