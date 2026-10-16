@extends('Layouts.Admin')

@section('title', 'Equipos e Inventario - AdminSena')

@section('contenido')
    @php
        // Normaliza la respuesta de la API (lista directa o paginada)
        if (is_array($equipos) && isset($equipos['data']) && is_array($equipos['data'])) {
            $equipos = $equipos['data'];
        } elseif (!is_array($equipos)) {
            $equipos = [];
        }

        /* ── Adaptadores de campos de la API ──────────────────────────────── */
        $get = function ($item, $keys, $default = '—') {
            foreach ((array) $keys as $key) {
                $value = data_get($item, $key);
                if ($value !== null && $value !== '') return $value;
            }
            return $default;
        };

        // La API devuelve: name, brand, equipment_type, environment.nombre
        $nombreDe   = fn($e) => (string) $get($e, ['name', 'nombre', 'nombre_equipo'], 'Sin nombre');
        $marcaDe    = fn($e) => (string) $get($e, ['brand', 'marca'], '—');
        $tipoDe     = fn($e) => (string) $get($e, ['equipment_type', 'tipo', 'tipo_equipo'], '—');
        $ambienteDe = fn($e) => (string) $get($e, ['environment.nombre', 'ambiente.nombre', 'ambiente_nombre'], '—');

        // Iniciales del nombre para el avatar
        $inicialesDe = function ($e) use ($nombreDe) {
            $palabras = preg_split('/\s+/', trim($nombreDe($e)));
            $ini = '';
            foreach (array_slice($palabras, 0, 2) as $p) {
                $ini .= mb_strtoupper(mb_substr($p, 0, 1, 'UTF-8'), 'UTF-8');
            }
            return $ini ?: 'E';
        };

        // Badge por tipo de equipo
        $badgeTipoDe = function ($e) use ($tipoDe) {
            $tipo = $tipoDe($e);
            $configs = [
                'Equipo de cómputo' => ['bg-blue-50',    'text-blue-700',    'ring-blue-200',    'fa-laptop'],
                'Equipo de redes'   => ['bg-violet-50',  'text-violet-700',  'ring-violet-200',  'fa-network-wired'],
                'Instrumento'       => ['bg-amber-50',   'text-amber-700',   'ring-amber-200',   'fa-ruler-combined'],
                'Simulador'         => ['bg-emerald-50', 'text-emerald-700', 'ring-emerald-200', 'fa-microchip'],
            ];
            [$bg, $text, $ring, $icon] = $configs[$tipo] ?? ['bg-slate-100', 'text-slate-600', 'ring-slate-200', 'fa-box'];
            return '<span class="inline-flex items-center gap-1.5 rounded-full ' . $bg . ' px-2.5 py-1 text-[11px] font-bold ' . $text . ' ring-1 ' . $ring . '">'
                 . '<i class="fa-solid ' . $icon . ' text-[10px]"></i>'
                 . e($tipo) . '</span>';
        };

        // Color del avatar según marca
        $avatarColorDe = function ($e) use ($marcaDe) {
            $marca = strtoupper($marcaDe($e));
            return match(true) {
                str_contains($marca, 'SENA')    => 'bg-gradient-to-br from-[#39A900] to-[#278000]',
                str_contains($marca, 'AULA')    => 'bg-gradient-to-br from-blue-500 to-blue-700',
                str_contains($marca, 'GENÉRIC') => 'bg-gradient-to-br from-slate-500 to-slate-700',
                default                         => 'bg-gradient-to-br from-[#081B28] to-[#0f2d44]',
            };
        };

        $total        = count($equipos);
        $porTipo      = collect($equipos)->groupBy(fn($e) => $tipoDe($e));
        $tiposUnicos  = $porTipo->count();
        $ambientesUnicos = collect($equipos)->pluck('environment.id')->filter()->unique()->count();
    @endphp

    <div class="space-y-6">

        {{-- Encabezado --}}
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <div class="mb-3 flex items-center gap-2">
                    <span class="h-1 w-8 rounded-full bg-[#39A900]"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#328d08]">Inventario institucional</span>
                </div>
                <h2 class="text-3xl font-bold tracking-tight text-[#081B28]">Equipos e Inventario</h2>
                <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500">
                    Gestiona los equipos registrados en el sistema y consulta su tipo y ambiente de ubicación.
                </p>
            </div>
            <a href="{{ route('equipos.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-[#39A900]/20 transition duration-200 hover:-translate-y-0.5 hover:bg-[#2e8800] hover:shadow-md focus:outline-none focus:ring-4 focus:ring-[#39A900]/20">
                <i class="fa-solid fa-plus text-xs"></i>
                Nuevo equipo
            </a>
        </div>

        {{-- Alertas --}}
        @if (session('success'))
            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                <i class="fa-solid fa-circle-check text-lg text-emerald-600"></i>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="flex items-center gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                <i class="fa-solid fa-circle-exclamation text-lg text-rose-600"></i>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- KPIs --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#081B28]/10 text-[#081B28]">
                    <i class="fa-solid fa-boxes-stacked text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Total equipos</p>
                    <p class="mt-0.5 text-2xl font-bold text-gray-900">{{ $total }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-700">
                    <i class="fa-solid fa-layer-group text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Tipos distintos</p>
                    <p class="mt-0.5 text-2xl font-bold text-gray-900">{{ $tiposUnicos }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]">
                    <i class="fa-solid fa-door-open text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Ambientes</p>
                    <p class="mt-0.5 text-2xl font-bold text-gray-900">{{ $ambientesUnicos }}</p>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            {{-- Barra superior --}}
            <div class="flex flex-col gap-4 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">Listado de equipos</h3>
                    <p class="mt-1 text-sm text-gray-500">Consulta nombre, marca, tipo de equipo y ambiente asignado.</p>
                </div>
                <div class="relative w-full sm:max-w-xs">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="buscarEquipo" type="search" placeholder="Buscar equipo..."
                           autocomplete="off"
                           class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
                </div>
            </div>

            {{-- Tabla escritorio --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-400">
                        <tr>
                            <th class="px-5 py-4 font-semibold w-12">#</th>
                            <th class="px-5 py-4 font-semibold">Nombre</th>
                            <th class="px-5 py-4 font-semibold">Marca</th>
                            <th class="px-5 py-4 font-semibold">Tipo</th>
                            <th class="px-5 py-4 font-semibold">Ambiente</th>
                            <th class="px-5 py-4 font-semibold text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaEquipos" class="divide-y divide-gray-100">
                        @forelse ($equipos as $equipo)
                            @php $id = $get($equipo, 'id', '—'); @endphp
                            <tr class="fila-equipo transition-colors hover:bg-[#F7F9F6]">

                                {{-- ID --}}
                                <td class="px-5 py-4 font-mono text-xs text-gray-400">#{{ $id }}</td>

                                {{-- Nombre --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-xs font-bold text-white shadow-sm {{ $avatarColorDe($equipo) }}">
                                            {{ $inicialesDe($equipo) }}
                                        </div>
                                        <span class="font-semibold text-gray-900">{{ $nombreDe($equipo) }}</span>
                                    </div>
                                </td>

                                {{-- Marca --}}
                                <td class="px-5 py-4 text-sm text-gray-600">{{ $marcaDe($equipo) }}</td>

                                {{-- Tipo --}}
                                <td class="px-5 py-4">{!! $badgeTipoDe($equipo) !!}</td>

                                {{-- Ambiente --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="fa-solid fa-door-open text-gray-300 text-xs"></i>
                                        {{ $ambienteDe($equipo) }}
                                    </div>
                                </td>

                                {{-- Acciones --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('equipos.show', $id) }}"
                                           title="Ver detalles"
                                           class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                                            <i class="fa-regular fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ route('equipos.edit', $id) }}"
                                           title="Editar"
                                           class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                                            <i class="fa-regular fa-pen-to-square text-sm"></i>
                                        </a>
                                        <form action="{{ route('equipos.destroy', $id) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar el equipo «{{ addslashes($nombreDe($equipo)) }}»?\nEsta acción no se puede deshacer.')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Eliminar"
                                                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-rose-50 hover:text-rose-600">
                                                <i class="fa-regular fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                                        <i class="fa-solid fa-boxes-stacked text-2xl"></i>
                                    </div>
                                    <h3 class="mt-4 font-semibold text-gray-900">No hay equipos registrados</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comienza registrando el primer equipo del inventario.</p>
                                    <a href="{{ route('equipos.create') }}"
                                       class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#39A900] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#2e8800]">
                                        <i class="fa-solid fa-plus text-xs"></i> Agregar equipo
                                    </a>
                                </td>
                            </tr>
                        @endforelse

                        {{-- Sin resultados búsqueda --}}
                        <tr id="sinResultados" class="hidden">
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fa-solid fa-magnifying-glass mb-3 block text-2xl text-gray-300"></i>
                                No se encontraron equipos que coincidan con la búsqueda.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pie --}}
            @if ($total > 0)
                <div class="flex items-center justify-between border-t border-gray-100 bg-gray-50/50 px-5 py-3.5">
                    <p id="contadorEquipos" class="text-xs text-gray-500">Mostrando {{ $total }} equipos</p>
                    <span class="inline-flex items-center gap-2 text-xs font-medium text-gray-500">
                        <span class="h-2 w-2 rounded-full bg-[#39A900]"></span>
                        Inventario institucional SENA
                    </span>
                </div>
            @endif
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buscador     = document.getElementById('buscarEquipo');
            const filas        = Array.from(document.querySelectorAll('.fila-equipo'));
            const sinResultados = document.getElementById('sinResultados');
            const contador     = document.getElementById('contadorEquipos');
            if (!buscador) return;
            buscador.addEventListener('input', function () {
                const q = this.value.toLowerCase().trim();
                let visibles = 0;
                filas.forEach(function (fila) {
                    const coincide = fila.textContent.toLowerCase().includes(q);
                    fila.style.display = coincide ? '' : 'none';
                    if (coincide) visibles++;
                });
                if (sinResultados) sinResultados.classList.toggle('hidden', visibles > 0 || filas.length === 0);
                if (contador) contador.textContent = `Mostrando ${visibles} de ${filas.length} equipos`;
            });
        });
    </script>
@endsection
