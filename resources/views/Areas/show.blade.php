@extends('Layouts.Admin')

@section('contenido')
    @php
        $nombre = data_get($area, 'nombre', 'Área sin nombre');
        $centro = data_get($area, 'trainingcenter.nombre', 'Sin centro asignado');
        $programas = data_get($area, 'programs', []);
        $totalProgramas = count($programas);
    @endphp

    <div class="min-h-screen bg-[#f6f8f5] px-5 py-8 sm:px-8 lg:px-10">

        <div class="mx-auto max-w-7xl">

            {{-- Navegación --}}
            <div class="mb-8 flex items-center gap-2 text-sm">
                <a href="{{ route('areas.index') }}" class="text-gray-500 transition hover:text-[#39A900]">
                    Áreas
                </a>

                <svg class="text-gray-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>

                <span class="font-medium text-gray-800">Detalle del área</span>
            </div>

            {{-- Encabezado principal --}}
            <header class="mb-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                <div>
                    <div class="mb-3 flex items-center gap-2">
                        <span class="h-1 w-8 rounded-full bg-[#39A900]"></span>
                        <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#328d08]">
                            Gestión académica
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-[#14251a] sm:text-4xl">
                        {{ $nombre }}
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500 sm:text-base">
                        Consulta la información del área y los programas de formación vinculados.
                    </p>
                </div>

                <a href="{{ route('areas.index') }}"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition duration-200 hover:border-gray-300 hover:bg-gray-50">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                    Volver al listado
                </a>
            </header>

            {{-- Resumen --}}
            <section class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- Tarjeta del área --}}
                <article
                    class="relative overflow-hidden rounded-2xl border border-gray-200/80 bg-white p-6 shadow-[0_2px_12px_rgba(20,37,26,0.03)] transition duration-300 hover:shadow-md sm:p-7">
                    <div
                        class="absolute right-0 top-0 h-28 w-28 translate-x-8 -translate-y-8 rounded-full bg-[#39A900]/[0.06]">
                    </div>

                    <div class="relative flex items-start gap-4">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#edf8e8] text-[#328d08]">
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 3 9 5-9 5-9-5 9-5Z" />
                                <path d="m3 12 9 5 9-5" />
                                <path d="m3 16 9 5 9-5" />
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-500">
                                Área de formación
                            </p>

                            <h2 class="mt-2 break-words text-xl font-bold text-[#17251b] sm:text-2xl">
                                {{ $nombre }}
                            </h2>

                            <div class="mt-4 flex items-center gap-2">
                                <span class="rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                    ID #{{ data_get($area, 'id', 'N/A') }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-[#328d08]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#39A900]"></span>
                                    Información registrada
                                </span>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Tarjeta del centro --}}
                <article
                    class="rounded-2xl border border-gray-200/80 bg-white p-6 shadow-[0_2px_12px_rgba(20,37,26,0.03)] transition duration-300 hover:shadow-md sm:p-7">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#f0f3f6] text-[#40566a]">
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21h18" />
                                <path d="M5 21V7l8-4v18" />
                                <path d="M19 21V11l-6-4" />
                                <path d="M9 9v.01M9 12v.01M9 15v.01M9 18v.01" />
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-500">
                                Centro de formación
                            </p>

                            <h2 class="mt-2 break-words text-xl font-bold leading-snug text-[#17251b]">
                                {{ $centro }}
                            </h2>

                            <div class="mt-4">
                                <span class="rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                    ID #{{ data_get($area, 'trainingcenter.id', 'N/A') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            </section>

            {{-- Sección de programas --}}
            <section
                class="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-[0_2px_12px_rgba(20,37,26,0.03)]">

                <div
                    class="flex flex-col gap-4 border-b border-gray-100 px-6 py-6 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf8e8] text-[#328d08]">
                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                                <path d="M8 7h8M8 11h6" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-[#17251b]">
                                Programas asociados
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Formación vinculada a esta área.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 self-start sm:self-center">
                        <span class="text-sm text-gray-500">Total registrados</span>
                        <span
                            class="flex h-9 min-w-9 items-center justify-center rounded-xl bg-[#edf8e8] px-3 text-sm font-bold text-[#328d08]">
                            {{ $totalProgramas }}
                        </span>
                    </div>
                </div>

                @if ($totalProgramas > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach ($programas as $programa)
                            <article
                                class="group flex items-center gap-4 px-6 py-5 transition duration-200 hover:bg-[#f9fcf7] sm:px-7">
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-gray-100 bg-gray-50 text-gray-500 transition group-hover:border-[#d8edcc] group-hover:bg-[#edf8e8] group-hover:text-[#328d08]">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 3 3 8l9 5 9-5-9-5Z" />
                                        <path d="M7 10.2v5.3c3 2.3 7 2.3 10 0v-5.3" />
                                        <path d="M21 8v6" />
                                    </svg>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="break-words font-semibold text-[#17251b]">
                                        {{ data_get($programa, 'nombre', 'Programa sin nombre') }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Programa de formación
                                    </p>
                                </div>

                                <div class="hidden shrink-0 text-right sm:block">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Identificador
                                    </p>
                                    <p class="mt-1 text-sm font-semibold text-gray-600">
                                        #{{ data_get($programa, 'id', 'N/A') }}
                                    </p>
                                </div>

                                <span
                                    class="shrink-0 rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-500">
                                    Área #{{ data_get($programa, 'area_id', 'N/A') }}
                                </span>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-16 text-center">
                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                            <svg width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                            </svg>
                        </div>

                        <h3 class="mt-4 font-semibold text-gray-800">
                            No hay programas asociados
                        </h3>
                        <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-500">
                            Esta área todavía no tiene programas registrados para mostrar.
                        </p>
                    </div>
                @endif

                <footer class="border-t border-gray-100 bg-gray-50/70 px-6 py-4 sm:px-7">
                    <p class="text-xs text-gray-500">
                        Mostrando {{ $totalProgramas }}
                        {{ $totalProgramas === 1 ? 'programa asociado' : 'programas asociados' }}
                        a esta área.
                    </p>
                </footer>
            </section>

            {{-- Pie --}}
            <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                <span class="h-1.5 w-1.5 rounded-full bg-[#39A900]"></span>
                AdminSena · Gestión de áreas de formación
            </div>

        </div>
    </div>
@endsection
