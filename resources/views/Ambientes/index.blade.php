@extends('Layouts.Admin')

@section('title', 'Ambientes de formación')

@section('contenido')
@php
    // Normaliza la respuesta de la API (lista directa o paginada)
    if (is_object($ambientes) && property_exists($ambientes, 'data')) {
        $ambientes = (array) $ambientes->data;
    } elseif (is_array($ambientes) && isset($ambientes['data']) && is_array($ambientes['data'])) {
        $ambientes = $ambientes['data'];
    } elseif (!is_array($ambientes)) {
        $ambientes = [];
    }

    $get = function ($item, $keys, $default = null) {
        foreach ((array) $keys as $key) {
            $value = data_get($item, $key);
            if ($value !== null && $value !== '') return $value;
        }
        return $default;
    };

    $nombreDe    = fn ($a) => (string) $get($a, ['nombre', 'nombre_ambiente', 'name'], 'Ambiente sin nombre');
    $tipoDe      = fn ($a) => (string) $get($a, ['tipo_ambiente', 'tipo', 'type', 'TIPO'], '');
    $capacidadDe = fn ($a) => (int) $get($a, ['capacidad', 'aforo', 'capacity'], 0);

    $centroDe = function ($a) use ($get) {
        $anidado = $get($a, ['trainingcenter.nombre', 'trainingcenter.name', 'centro.nombre'], null);
        if ($anidado) return (string) $anidado;

        $directo = $get($a, ['centro_nombre', 'nombre_centro'], null);
        if ($directo) return (string) $directo;

        $id = $get($a, ['trainingcenter_id', 'centro_id', 'id_centro'], null);
        return ($id !== null && $id !== '') ? 'Centro #' . $id : 'Centro no asociado';
    };

    $total            = count($ambientes);
    $capacidadTotal   = collect($ambientes)->sum($capacidadDe);
    $tiposRegistrados = collect($ambientes)->map($tipoDe)->filter()->unique()->count();
@endphp

<div class="space-y-6">

    {{-- Encabezado --}}
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                <i class="fa-solid fa-house"></i>
                <span>Administración</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="font-medium text-[#278000]">Ambientes</span>
            </div>

            <h1 class="text-2xl font-bold text-gray-900">
                Ambientes de formación
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Consulta y administra los ambientes disponibles para la formación.
            </p>
        </div>

        <a href="{{ route('ambientes.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#2e8800] focus:outline-none focus:ring-2 focus:ring-[#39A900] focus:ring-offset-2">
            <i class="fa-solid fa-plus"></i>
            Registrar ambiente
        </a>
    </div>

    {{-- Mensajes --}}
    @if (session('success'))
        <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
            <i class="fa-solid fa-circle-check mt-0.5 text-lg"></i>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
            <i class="fa-solid fa-circle-exclamation mt-0.5 text-lg"></i>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Resumen --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]">
                <i class="fa-solid fa-door-open text-xl"></i>
            </div>

            <div>
                <p class="text-sm text-gray-500">Total de ambientes</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">
                    {{ $total }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                <i class="fa-solid fa-users text-xl"></i>
            </div>

            <div>
                <p class="text-sm text-gray-500">Capacidad total</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">
                    {{ number_format($capacidadTotal) }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <i class="fa-solid fa-tags text-xl"></i>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tipos de ambiente</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">
                    {{ $tiposRegistrados }}
                </p>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        {{-- Barra de búsqueda --}}
        <div class="flex flex-col gap-4 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-gray-900">
                    Listado de ambientes
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Revisa los datos y las acciones disponibles.
                </p>
            </div>

            <div class="relative w-full sm:max-w-xs">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>

                <input id="buscarAmbiente" type="search" placeholder="Buscar por nombre, tipo o centro..."
                    autocomplete="off"
                    class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[860px] text-left text-sm">

                <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Ambiente</th>
                        <th class="px-6 py-4 font-semibold">Centro</th>
                        <th class="px-6 py-4 font-semibold">Tipo</th>
                        <th class="px-6 py-4 font-semibold">Capacidad</th>
                        <th class="px-6 py-4 text-right font-semibold">Acciones</th>
                    </tr>
                </thead>

                <tbody id="tablaAmbientes" class="divide-y divide-gray-100">

                    @forelse ($ambientes as $ambiente)
                        <tr class="fila-ambiente transition-colors hover:bg-[#F7F9F6]">

                            {{-- Nombre --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]">
                                        <i class="fa-solid fa-door-open text-lg"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900">
                                            {{ $nombreDe($ambiente) }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-400">
                                            Código: {{ $get($ambiente, 'id', 'N/A') }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Centro --}}
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-2 text-gray-600">
                                    <i class="fa-solid fa-building-columns mt-0.5 text-gray-400"></i>

                                    <span>{{ $centroDe($ambiente) }}</span>
                                </div>
                            </td>

                            {{-- Tipo --}}
                            <td class="px-6 py-4 text-gray-600">
                                {{ $tipoDe($ambiente) ?: '—' }}
                            </td>

                            {{-- Capacidad --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 text-gray-600">
                                    <i class="fa-solid fa-users text-gray-400"></i>
                                    {{ number_format($capacidadDe($ambiente)) }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    <a href="{{ route('ambientes.show', data_get($ambiente, 'id')) }}" title="Ver detalles"
                                        aria-label="Ver detalles"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-900">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="{{ route('ambientes.edit', data_get($ambiente, 'id')) }}" title="Editar ambiente"
                                        aria-label="Editar ambiente"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg text-[#278000] transition hover:bg-[#E8F7DF]">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('ambientes.destroy', data_get($ambiente, 'id')) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este ambiente de formación?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" title="Eliminar ambiente" aria-label="Eliminar ambiente"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-50">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div
                                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                                    <i class="fa-solid fa-door-open text-2xl"></i>
                                </div>

                                <h3 class="mt-4 font-semibold text-gray-900">
                                    No hay ambientes registrados
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Registra un ambiente de formación para comenzar.
                                </p>

                                <a href="{{ route('ambientes.create') }}"
                                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#39A900] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2e8800]">
                                    <i class="fa-solid fa-plus"></i>
                                    Registrar ambiente
                                </a>
                            </td>
                        </tr>
                    @endforelse

                    {{-- Resultado de búsqueda vacío --}}
                    <tr id="sinResultados" class="hidden">
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fa-solid fa-magnifying-glass mb-3 block text-2xl text-gray-300"></i>
                            No se encontraron ambientes que coincidan con la búsqueda.
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        {{-- Pie de tabla --}}
        @if ($total > 0)
            <div
                class="flex flex-col gap-2 border-t border-gray-100 bg-white px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p id="contadorAmbientes" class="text-xs text-gray-500">
                    Mostrando {{ $total }} ambientes de formación
                </p>

                <span class="inline-flex items-center gap-2 text-xs font-medium text-gray-500">
                    <span class="h-2 w-2 rounded-full bg-[#39A900]"></span>
                    Información institucional
                </span>
            </div>
        @endif

    </div>
</div>

{{-- Búsqueda en tiempo real --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buscador = document.getElementById('buscarAmbiente');
        const filas = Array.from(document.querySelectorAll('.fila-ambiente'));
        const sinResultados = document.getElementById('sinResultados');
        const contador = document.getElementById('contadorAmbientes');

        if (!buscador) return;

        buscador.addEventListener('input', function () {
            const busqueda = this.value.toLowerCase().trim();
            let visibles = 0;

            filas.forEach(function (fila) {
                const coincide = fila.textContent.toLowerCase().includes(busqueda);

                fila.style.display = coincide ? '' : 'none';

                if (coincide) {
                    visibles++;
                }
            });

            if (sinResultados) {
                sinResultados.classList.toggle('hidden', visibles > 0 || filas.length === 0);
            }

            if (contador) {
                contador.textContent = `Mostrando ${visibles} de ${filas.length} ambientes de formación`;
            }
        });
    });
</script>
@endsection
