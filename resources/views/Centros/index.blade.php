@extends('Layouts.Admin')

@section('page-title', 'Centros de formación')

@section('contenido')
    <div class="space-y-6">

        {{-- Encabezado --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                    <i class="fa-solid fa-house"></i>
                    <span>Administración</span>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span class="font-medium text-[#278000]">Centros de formación</span>
                </div>

                <h1 class="text-2xl font-bold text-gray-900">
                    Centros de formación
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Consulta y administra los centros de formación registrados en el sistema.
                </p>
            </div>

            <a href="{{ route('centros.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#2e8800] focus:outline-none focus:ring-2 focus:ring-[#39A900] focus:ring-offset-2">
                <i class="fa-solid fa-plus"></i>
                Registrar centro
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
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]">
                    <i class="fa-solid fa-building text-xl"></i>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Total de centros</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ is_countable($centros) ? count($centros) : 0 }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-location-dot text-xl"></i>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Gestión institucional</p>
                    <p class="mt-1 text-base font-bold text-gray-900">
                        Centros de formación SENA
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
                        Listado de centros
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Revisa los datos y las acciones disponibles.
                    </p>
                </div>

                <div class="relative w-full sm:max-w-xs">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>

                    <input id="buscarCentro" type="search" placeholder="Buscar por nombre o dirección..."
                        autocomplete="off"
                        class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left text-sm">

                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Centro de formación</th>
                            <th class="px-6 py-4 font-semibold">Dirección</th>
                            <th class="px-6 py-4 text-right font-semibold">Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaCentros" class="divide-y divide-gray-100">

                        @forelse ($centros as $centro)
                            <tr class="fila-centro transition-colors hover:bg-[#F7F9F6]">

                                {{-- Nombre --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]">
                                            <i class="fa-solid fa-building text-lg"></i>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="nombre-centro font-semibold text-gray-900">
                                                {{ data_get($centro, 'nombre', 'Sin nombre') }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-400">
                                                Código: {{ data_get($centro, 'id', 'N/A') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Dirección --}}
                                <td class="direccion-centro px-6 py-4">
                                    <div class="flex items-start gap-2 text-gray-600">
                                        <i class="fa-solid fa-location-dot mt-0.5 text-gray-400"></i>

                                        <span>
                                            {{ data_get($centro, 'direccion', 'Sin dirección registrada') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">

                                        <a href="{{ route('centros.show', data_get($centro, 'id')) }}" title="Ver detalles"
                                            aria-label="Ver detalles"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-900">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <a href="{{ route('centros.edit', data_get($centro, 'id')) }}" title="Editar centro"
                                            aria-label="Editar centro"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg text-[#278000] transition hover:bg-[#E8F7DF]">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('centros.destroy', data_get($centro, 'id')) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Estás seguro de que deseas eliminar este centro de formación?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Eliminar centro" aria-label="Eliminar centro"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-50">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                                        <i class="fa-solid fa-building text-2xl"></i>
                                    </div>

                                    <h3 class="mt-4 font-semibold text-gray-900">
                                        No hay centros registrados
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Registra un centro de formación para comenzar.
                                    </p>

                                    <a href="{{ route('centros.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#39A900] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2e8800]">
                                        <i class="fa-solid fa-plus"></i>
                                        Registrar centro
                                    </a>
                                </td>
                            </tr>
                        @endforelse

                        {{-- Resultado de búsqueda vacío --}}
                        <tr id="sinResultados" class="hidden">
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                <i class="fa-solid fa-magnifying-glass mb-3 block text-2xl text-gray-300"></i>
                                No se encontraron centros que coincidan con la búsqueda.
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- Pie de tabla --}}
            @if (count($centros) > 0)
                <div
                    class="flex flex-col gap-2 border-t border-gray-100 bg-white px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <p id="contadorCentros" class="text-xs text-gray-500">
                        Mostrando {{ count($centros) }} centros de formación
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
        document.addEventListener('DOMContentLoaded', function() {
            const buscador = document.getElementById('buscarCentro');
            const filas = Array.from(document.querySelectorAll('.fila-centro'));
            const sinResultados = document.getElementById('sinResultados');
            const contador = document.getElementById('contadorCentros');

            if (!buscador) return;

            buscador.addEventListener('input', function() {
                const busqueda = this.value.toLowerCase().trim();
                let visibles = 0;

                filas.forEach(function(fila) {
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
                    contador.textContent = `Mostrando ${visibles} de ${filas.length} centros de formación`;
                }
            });
        });
    </script>
@endsection
