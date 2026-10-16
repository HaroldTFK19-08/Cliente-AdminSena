@extends('Layouts.Admin')
@section('title', 'Áreas de Formación - AdminSena')
@section('page-title', 'Gestión de Áreas')
@section('contenido')
    @php
        $totalAreas = is_countable($areas) ? count($areas) : 0;
        $totalCentros = collect($areas)->pluck('trainingcenter.id')->filter()->unique()->count();
    @endphp
    <div class="space-y-7">
        {{-- Encabezado --}}
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <div class="mb-3 flex items-center gap-2">
                    <span class="h-1 w-8 rounded-full bg-[#39A900]"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#328d08]">
                        Gestión académica
                    </span>
                </div>
                <h2 class="text-3xl font-bold tracking-tight text-[#081B28]">
                    Áreas de Formación
                </h2>
                <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500">
                    Administra las áreas académicas y consulta los centros de formación vinculados.
                </p>
            </div>
            <a href="{{ route('areas.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-[#39A900]/20 transition duration-200 hover:-translate-y-0.5 hover:bg-[#2e8800] hover:shadow-md focus:outline-none focus:ring-4 focus:ring-[#39A900]/20">
                <i class="fa-solid fa-plus text-xs"></i>
                Nueva área
            </a>
        </div>
        {{-- Alertas --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
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
        {{-- Indicadores --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <article
                class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition duration-300 hover:shadow-md">
                <div
                    class="absolute -right-7 -top-7 h-28 w-28 rounded-full bg-[#39A900]/[0.06] transition group-hover:scale-110">
                </div>
                <div class="relative flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total de áreas
                        </p>
                        <p class="mt-3 text-3xl font-bold tracking-tight text-[#081B28]">
                            {{ $totalAreas }}
                        </p>
                        <p class="mt-2 text-xs text-slate-400">
                            Registros disponibles en el sistema
                        </p>
                    </div>
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#39A900]/10 text-[#278000]">
                        <i class="fa-solid fa-layer-group text-xl"></i>
                    </div>
                </div>
            </article>
            <article
                class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition duration-300 hover:shadow-md">
                <div
                    class="absolute -right-7 -top-7 h-28 w-28 rounded-full bg-blue-500/[0.05] transition group-hover:scale-110">
                </div>
                <div class="relative flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Centros vinculados
                        </p>
                        <p class="mt-3 text-3xl font-bold tracking-tight text-[#081B28]">
                            {{ $totalCentros }}
                        </p>
                        <p class="mt-2 text-xs text-slate-400">
                            Centros con áreas registradas
                        </p>
                    </div>
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i class="fa-solid fa-building text-xl"></i>
                    </div>
                </div>
            </article>
        </div>
        {{-- Listado --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
            {{-- Cabecera de tabla y buscador --}}
            <div
                class="flex flex-col justify-between gap-5 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:p-6">
                <div>
                    <h3 class="text-base font-bold text-[#081B28]">
                        Listado de áreas
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Consulta, edita o elimina las áreas registradas.
                    </p>
                </div>
                <div class="relative w-full sm:max-w-xs">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                    <input id="buscarArea" type="search" placeholder="Buscar área o centro..."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10">
                </div>
            </div>
            {{-- Tabla --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead
                        class="border-b border-slate-100 bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Área de formación</th>
                            <th class="px-6 py-4">Centro de formación</th>
                            <th class="px-6 py-4 text-center">Identificador</th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaAreas" class="divide-y divide-slate-100">
                        @forelse ($areas as $area)
                            <tr class="fila-area transition-colors duration-150 hover:bg-[#f8fbf6]"
                                data-busqueda="{{ mb_strtolower(data_get($area, 'nombre', '') . ' ' . data_get($area, 'trainingcenter.nombre', '')) }}">
                                {{-- Área --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#39A900]/10 bg-[#39A900]/10 text-[#278000]">
                                            <i class="fa-solid fa-layer-group text-sm"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-[#081B28]">
                                                {{ data_get($area, 'nombre', 'Sin nombre') }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400">
                                                Área académica
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                {{-- Centro --}}
                                <td class="px-6 py-5">
                                    <div class="flex min-w-52 items-start gap-2.5">
                                        <i class="fa-solid fa-building mt-0.5 text-slate-400"></i>
                                        <span class="max-w-xs leading-5 text-slate-600">
                                            {{ data_get($area, 'trainingcenter.nombre', 'Sin centro asignado') }}
                                        </span>
                                    </div>
                                </td>
                                {{-- ID --}}
                                <td class="px-6 py-5 text-center">
                                    <span
                                        class="inline-flex rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                        #{{ data_get($area, 'id', 'N/A') }}
                                    </span>
                                </td>
                                {{-- Acciones --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('areas.show', $area['id']) }}" title="Ver detalles"
                                            aria-label="Ver detalles"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('areas.edit', $area['id']) }}" title="Editar área"
                                            aria-label="Editar área"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-[#cde8c0] hover:bg-[#edf8e8] hover:text-[#278000]">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <form action="{{ route('areas.destroy', $area['id']) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta área?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Eliminar área" aria-label="Eliminar área"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <i class="fa-solid fa-folder-open text-xl"></i>
                                    </div>
                                    <h3 class="mt-4 font-bold text-[#081B28]">
                                        No hay áreas registradas
                                    </h3>
                                    <p class="mt-2 text-sm text-slate-500">
                                        Registra una nueva área para comenzar.
                                    </p>
                                    <a href="{{ route('areas.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#39A900] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2e8800]">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                        Nueva área
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Búsqueda sin resultados --}}
            <div id="sinResultados" class="hidden border-t border-slate-100 px-6 py-12 text-center">
                <i class="fa-solid fa-magnifying-glass mb-3 text-2xl text-slate-300"></i>
                <p class="font-semibold text-[#081B28]">
                    No se encontraron coincidencias
                </p>
                <p class="mt-1 text-sm text-slate-500">
                    Prueba con otro nombre de área o centro de formación.
                </p>
            </div>
            {{-- Pie --}}
            @if ($totalAreas > 0)
                <footer
                    class="flex flex-col gap-2 border-t border-slate-100 bg-slate-50/60 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <p id="contadorAreas" class="text-xs font-medium text-slate-500">
                        Mostrando {{ $totalAreas }} {{ $totalAreas === 1 ? 'área' : 'áreas' }}
                    </p>
                    <span class="text-xs text-slate-400">
                        AdminSena · Gestión académica
                    </span>
                </footer>
            @endif
        </section>
    </div>
    {{-- Filtro de búsqueda --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buscador = document.getElementById('buscarArea');
            const filas = [...document.querySelectorAll('.fila-area')];
            const sinResultados = document.getElementById('sinResultados');
            const contador = document.getElementById('contadorAreas');
            if (!buscador) return;
            buscador.addEventListener('input', () => {
                const consulta = buscador.value.trim().toLocaleLowerCase();
                let visibles = 0;
                filas.forEach(fila => {
                    const texto = fila.dataset.busqueda || '';
                    const coincide = texto.includes(consulta);
                    fila.classList.toggle('hidden', !coincide);
                    if (coincide) visibles++;
                });
                sinResultados.classList.toggle(
                    'hidden',
                    visibles > 0 || filas.length === 0
                );
                if (contador) {
                    contador.textContent =
                        `Mostrando ${visibles} ${visibles === 1 ? 'área' : 'áreas'}`;
                }
            });
        });
    </script>
@endsection
