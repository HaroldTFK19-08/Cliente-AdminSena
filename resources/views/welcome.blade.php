@extends('Layouts.Admin')

@section('title', 'Inicio - AdminSena')

@section('contenido')
    @if (data_get($usuario, 'rol') !== 'Admin')
        @include('Home.usuario')
    @else
    @php
        // Totales calculados con las respuestas de la API que envía HomeController
        $listaEquipos = collect($equipos ?? []);
        $totalEquipos = $listaEquipos->count();
        $totalAmbientes = count($ambientes ?? []);
        $totalCentros = count($centros ?? []);
        $totalTipos = $listaEquipos->pluck('equipment_type')->filter()->unique()->count();
        $ultimosEquipos = $listaEquipos->sortByDesc('id')->take(5)->values()->all();
    @endphp
    <div class="space-y-8">

        {{-- Bienvenida --}}
        <section class="relative overflow-hidden rounded-3xl bg-[#081B28] p-6 shadow-lg sm:p-8 lg:p-10">
            <div class="absolute -right-16 -top-20 h-64 w-64 rounded-full bg-[#39A900]/20 blur-3xl"></div>
            <div class="absolute -bottom-20 right-1/3 h-48 w-48 rounded-full bg-[#39A900]/10 blur-3xl"></div>

            <div class="relative flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
                <div class="max-w-2xl">
                    <div
                        class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-semibold text-[#90EE90]">
                        <span class="h-2 w-2 rounded-full bg-[#39A900]"></span>
                        PLATAFORMA DE GESTIÓN INSTITUCIONAL
                    </div>

                    <h1 class="text-3xl font-extrabold leading-tight text-white sm:text-4xl">
                        Hola, {{ data_get($usuario, 'nombre_1', 'administrador') }}.
                        <span class="block text-[#65D62E]">Bienvenido a AdminSena</span>
                    </h1>

                    <p class="mt-4 max-w-xl text-sm leading-7 text-slate-300 sm:text-base">
                        Administra los equipos, ambientes de formación y recursos institucionales
                        desde un solo lugar.
                    </p>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('equipos.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#39A900]/20 transition hover:-translate-y-0.5 hover:bg-[#2e8800]">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            Gestionar equipos
                        </a>

                        <a href="{{ route('equipos.create') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/15 bg-white/5 px-5 py-3 text-sm font-bold text-white transition hover:bg-white/10">
                            <i class="fa-solid fa-plus"></i>
                            Registrar equipo
                        </a>
                    </div>
                </div>

                <div class="hidden shrink-0 items-center justify-center lg:flex">
                    <div
                        class="flex h-36 w-36 items-center justify-center rounded-[2rem] border border-white/10 bg-white/5 shadow-2xl">
                        <i class="fa-solid fa-building-columns text-6xl text-[#39A900]"></i>
                    </div>
                </div>
            </div>
        </section>

        {{-- Título de estadísticas --}}
        <section class="space-y-5">
            <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-end">
                <div>
                    <h2 class="text-xl font-extrabold text-[#081B28]">
                        Resumen general
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Consulta rápida de los recursos institucionales.
                    </p>
                </div>

                <span class="text-xs font-medium text-slate-400">
                    Indicadores del sistema
                </span>
            </div>

            {{-- Tarjetas de estadísticas --}}
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Equipos --}}
                <article
                    class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#39A900]/10 text-[#39A900]">
                            <i class="fa-solid fa-laptop text-xl"></i>
                        </div>

                        <span class="rounded-lg bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-500">
                            Inventario
                        </span>
                    </div>

                    <p class="mt-5 text-sm font-medium text-slate-500">
                        Equipos registrados
                    </p>

                    <p class="mt-1 text-3xl font-extrabold text-[#081B28]">
                        {{ $totalEquipos ?? '—' }}
                    </p>

                    <a href="{{ route('equipos.index') }}"
                        class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-[#278000] transition group-hover:gap-3">
                        Ver equipos
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </article>

                {{-- Ambientes --}}
                <article
                    class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                            <i class="fa-solid fa-door-open text-xl"></i>
                        </div>

                        <span class="rounded-lg bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-500">
                            Formación
                        </span>
                    </div>

                    <p class="mt-5 text-sm font-medium text-slate-500">
                        Ambientes registrados
                    </p>

                    <p class="mt-1 text-3xl font-extrabold text-[#081B28]">
                        {{ $totalAmbientes ?? '—' }}
                    </p>

                    <p class="mt-4 text-xs text-slate-400">
                        Espacios de formación institucional.
                    </p>
                </article>

                {{-- Centros --}}
                <article
                    class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                            <i class="fa-solid fa-building text-xl"></i>
                        </div>

                        <span class="rounded-lg bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-500">
                            Institución
                        </span>
                    </div>

                    <p class="mt-5 text-sm font-medium text-slate-500">
                        Centros de formación
                    </p>

                    <p class="mt-1 text-3xl font-extrabold text-[#081B28]">
                        {{ $totalCentros ?? '—' }}
                    </p>

                    <p class="mt-4 text-xs text-slate-400">
                        Centros vinculados al sistema.
                    </p>
                </article>

                {{-- Tipos de equipo --}}
                <article
                    class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                            <i class="fa-solid fa-layer-group text-xl"></i>
                        </div>

                        <span class="rounded-lg bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-500">
                            Clasificación
                        </span>
                    </div>

                    <p class="mt-5 text-sm font-medium text-slate-500">
                        Tipos de equipos
                    </p>

                    <p class="mt-1 text-3xl font-extrabold text-[#081B28]">
                        {{ $totalTipos ?? '—' }}
                    </p>

                    <p class="mt-4 text-xs text-slate-400">
                        Categorías del inventario.
                    </p>
                </article>

            </div>
        </section>

        {{-- Accesos rápidos y actividad --}}
        <section class="grid gap-6 xl:grid-cols-3">

            {{-- Accesos rápidos --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
                <div class="mb-5">
                    <h2 class="text-lg font-extrabold text-[#081B28]">
                        Accesos rápidos
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Accede directamente a los módulos principales.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">

                    <a href="{{ route('equipos.index') }}"
                        class="group flex items-center gap-4 rounded-2xl border border-slate-200 p-4 transition hover:border-[#39A900]/40 hover:bg-[#39A900]/5">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#39A900]/10 text-[#39A900] transition group-hover:bg-[#39A900] group-hover:text-white">
                            <i class="fa-solid fa-boxes-stacked text-lg"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-[#081B28]">
                                Inventario de equipos
                            </h3>
                            <p class="mt-1 text-xs text-slate-500">
                                Consulta y administra los equipos.
                            </p>
                        </div>

                        <i
                            class="fa-solid fa-chevron-right text-xs text-slate-400 transition group-hover:translate-x-1 group-hover:text-[#39A900]"></i>
                    </a>

                    <a href="{{ route('equipos.create') }}"
                        class="group flex items-center gap-4 rounded-2xl border border-slate-200 p-4 transition hover:border-[#39A900]/40 hover:bg-[#39A900]/5">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">
                            <i class="fa-solid fa-circle-plus text-lg"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-[#081B28]">
                                Registrar equipo
                            </h3>
                            <p class="mt-1 text-xs text-slate-500">
                                Agrega un recurso al inventario.
                            </p>
                        </div>

                        <i
                            class="fa-solid fa-chevron-right text-xs text-slate-400 transition group-hover:translate-x-1 group-hover:text-[#39A900]"></i>
                    </a>

                    <a href="{{ route('ambientes.index') }}"
                        class="group flex items-center gap-4 rounded-2xl border border-slate-200 p-4 transition hover:border-[#39A900]/40 hover:bg-[#39A900]/5">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600 transition group-hover:bg-sky-600 group-hover:text-white">
                            <i class="fa-solid fa-door-open text-lg"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-[#081B28]">
                                Ambientes
                            </h3>
                            <p class="mt-1 text-xs text-slate-500">
                                Consulta los espacios de formación.
                            </p>
                        </div>

                        <i
                            class="fa-solid fa-chevron-right text-xs text-slate-400 transition group-hover:translate-x-1 group-hover:text-[#39A900]"></i>
                    </a>

                    <a href="{{ route('centros.index') }}"
                        class="group flex items-center gap-4 rounded-2xl border border-slate-200 p-4 transition hover:border-[#39A900]/40 hover:bg-[#39A900]/5">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 transition group-hover:bg-violet-600 group-hover:text-white">
                            <i class="fa-solid fa-building text-lg"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-[#081B28]">
                                Centros de formación
                            </h3>
                            <p class="mt-1 text-xs text-slate-500">
                                Administra los centros institucionales.
                            </p>
                        </div>

                        <i
                            class="fa-solid fa-chevron-right text-xs text-slate-400 transition group-hover:translate-x-1 group-hover:text-[#39A900]"></i>
                    </a>

                </div>
            </div>

            {{-- Panel informativo --}}
            <aside class="flex flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#39A900]/10 text-[#39A900]">
                        <i class="fa-solid fa-shield-halved text-lg"></i>
                    </div>

                    <div>
                        <h2 class="font-extrabold text-[#081B28]">
                            AdminSena
                        </h2>
                        <p class="text-xs text-slate-500">
                            Gestión institucional
                        </p>
                    </div>
                </div>

                <div class="my-6 h-px bg-slate-100"></div>

                <h3 class="text-sm font-bold text-[#081B28]">
                    Mantén el inventario actualizado
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Registra los equipos correctamente y asígnalos al ambiente de formación correspondiente
                    para facilitar su consulta y administración.
                </p>

                <div class="mt-5 rounded-xl border border-[#39A900]/20 bg-[#39A900]/5 p-4">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-lightbulb mt-0.5 text-[#39A900]"></i>
                        <p class="text-xs leading-5 text-slate-600">
                            <span class="font-bold text-[#278000]">Recomendación:</span>
                            verifica el nombre, la marca, el tipo y el ambiente de cada equipo al registrarlo.
                        </p>
                    </div>
                </div>

                <a href="{{ route('equipos.index') }}"
                    class="mt-auto inline-flex items-center justify-center gap-2 pt-6 text-sm font-bold text-[#278000] transition hover:gap-3">
                    Ir al inventario
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </aside>

        </section>

        {{-- Últimos equipos registrados --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div
                class="flex flex-col justify-between gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center">
                <div>
                    <h2 class="text-lg font-extrabold text-[#081B28]">
                        Últimos equipos registrados
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Consulta los equipos incorporados recientemente.
                    </p>
                </div>

                <a href="{{ route('equipos.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-[#278000] transition hover:gap-3">
                    Ver todos
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            @if (isset($ultimosEquipos) && count($ultimosEquipos) > 0)

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Equipo
                                </th>
                                <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Marca
                                </th>
                                <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Tipo
                                </th>
                                <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Ambiente
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach ($ultimosEquipos as $equipo)
                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#39A900]/10 text-[#39A900]">
                                                <i class="fa-solid fa-laptop"></i>
                                            </div>

                                            <div>
                                                <p class="text-sm font-bold text-[#081B28]">
                                                    {{ data_get($equipo, 'name', 'Equipo sin nombre') }}
                                                </p>
                                                <p class="mt-0.5 text-xs text-slate-400">
                                                    ID #{{ data_get($equipo, 'id', '—') }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ data_get($equipo, 'brand', '—') ?: '—' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ data_get($equipo, 'equipment_type', '—') ?: '—' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <span class="inline-flex items-center gap-2">
                                            <i class="fa-solid fa-location-dot text-[#39A900]"></i>
                                            {{ data_get($equipo, 'environment.nombre', 'Sin ambiente') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                        <i class="fa-solid fa-box-open text-2xl"></i>
                    </div>

                    <h3 class="mt-4 font-bold text-[#081B28]">
                        No hay equipos para mostrar
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        Cuando registres equipos, aparecerán aquí.
                    </p>

                    <a href="{{ route('equipos.create') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#39A900] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#2e8800]">
                        <i class="fa-solid fa-plus"></i>
                        Registrar primer equipo
                    </a>
                </div>
            @endif

        </section>

    </div>
    @endif
@endsection
