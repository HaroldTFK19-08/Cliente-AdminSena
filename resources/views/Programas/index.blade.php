@extends('Layouts.Admin')

@section('title', 'Programas de formación - AdminSena')

@section('contenido')
    <div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">

        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="mb-2 text-sm text-slate-500">
                    Inicio / Gestión académica / Programas
                </p>
                <h1 class="text-3xl font-bold text-[#081B28]">
                    Programas de formación
                </h1>
                <p class="mt-2 text-slate-500">
                    Consulta y administra los programas de formación.
                </p>
            </div>

            <a href="{{ route('programas.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 font-semibold text-white transition hover:bg-[#2f8d00]">
                <i class="fa-solid fa-plus"></i>
                Nuevo programa
            </a>
        </div>

        @if (session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
                <i class="fa-solid fa-circle-check mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @php
            $lista = collect($programas ?? []);
        @endphp

        <div class="mb-6 grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total de programas</p>
                        <p class="mt-2 text-3xl font-bold text-[#081B28]">
                            {{ $lista->count() }}
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-[#247A16]">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Áreas de formación</p>
                        <p class="mt-2 text-3xl font-bold text-[#081B28]">
                            {{ $lista->pluck('area.nombre')->filter()->unique()->count() }}
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <i class="fa-solid fa-building text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-slate-200 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-[#081B28]">Listado de programas</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Información recibida desde la API.
                    </p>
                </div>

                <div class="relative w-full sm:max-w-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input id="busqueda" type="text" placeholder="Buscar programa, código o área..."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none focus:border-[#39A900] focus:ring-4 focus:ring-green-100">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px] text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Programa</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Código</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Nivel</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Área</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaProgramas" class="divide-y divide-slate-100">
                        @forelse($lista as $programa)
                            <tr class="fila-programa transition hover:bg-green-50/40">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-[#247A16]">
                                            <i class="fa-solid fa-book-open"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-[#081B28]">
                                                {{ data_get($programa, 'nombre', 'Sin nombre') }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400">
                                                ID: {{ data_get($programa, 'id', '—') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="rounded-lg bg-slate-100 px-3 py-2 font-mono text-sm text-slate-700">
                                        {{ data_get($programa, 'codigo_programa', '—') }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700">
                                        {{ data_get($programa, 'nivel_programa', 'No especificado') }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-600">
                                        <i class="fa-solid fa-building mr-2 text-slate-400"></i>
                                        {{ data_get($programa, 'area.nombre', 'Sin área asignada') }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('programas.show', data_get($programa, 'id')) }}"
                                            title="Ver detalles"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-blue-50 hover:text-blue-700">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <a href="{{ route('programas.edit', data_get($programa, 'id')) }}" title="Editar"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-green-50 hover:text-[#247A16]">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('programas.destroy', data_get($programa, 'id')) }}"
                                            method="POST" onsubmit="return confirm('¿Deseas eliminar este programa?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Eliminar"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-red-50 hover:text-red-600">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <i class="fa-solid fa-graduation-cap text-4xl text-slate-300"></i>
                                    <h3 class="mt-4 font-bold text-[#081B28]">No hay programas registrados</h3>
                                    <p class="mt-2 text-sm text-slate-500">
                                        Registra un programa para que aparezca en este listado.
                                    </p>
                                    <a href="{{ route('programas.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#39A900] px-4 py-3 font-semibold text-white hover:bg-[#2f8d00]">
                                        <i class="fa-solid fa-plus"></i>
                                        Registrar programa
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="sinResultados" class="hidden border-t border-slate-100 p-8 text-center text-sm text-slate-500">
                No se encontraron programas con esa búsqueda.
            </div>

            <div class="border-t border-slate-200 bg-slate-50 px-6 py-4 text-sm text-slate-500">
                Total de registros: <span id="totalProgramas" class="font-bold text-[#081B28]">{{ $lista->count() }}</span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const busqueda = document.getElementById('busqueda');
            const filas = document.querySelectorAll('.fila-programa');
            const sinResultados = document.getElementById('sinResultados');
            const total = document.getElementById('totalProgramas');

            busqueda.addEventListener('input', () => {
                const texto = busqueda.value.toLowerCase().trim();
                let visibles = 0;

                filas.forEach(fila => {
                    const coincide = fila.textContent.toLowerCase().includes(texto);
                    fila.classList.toggle('hidden', !coincide);
                    if (coincide) visibles++;
                });

                total.textContent = visibles;
                sinResultados.classList.toggle('hidden', visibles > 0 || filas.length === 0);
            });
        });
    </script>
@endsection
