@extends('Layouts.Admin')

@section('title', 'Editar Equipo - AdminSena')

@section('contenido')
    @php
        $get = fn($keys, $default = '') => collect($keys)->reduce(
            fn($carry, $key) => $carry ??
                (data_get($equipo, $key) !== null && data_get($equipo, $key) !== '' ? data_get($equipo, $key) : null),
            null,
        ) ?? $default;

        $id = $get(['id'], '');

        $nombre = old('name', $get(['name', 'nombre']));
        $marca = old('brand', $get(['brand', 'marca']));
        $tipo = old('equipment_type', $get(['equipment_type']));

        $ambienteId = old('environment_id', $get(['environment_id', 'environment.id'], ''));
    @endphp

    <div class="mx-auto max-w-3xl space-y-6">

        {{-- Encabezado --}}
        <div class="relative overflow-hidden rounded-3xl bg-[#081B28] p-6 shadow-lg sm:p-8">
            <div class="absolute -right-10 -top-16 h-48 w-48 rounded-full bg-[#39A900]/20 blur-3xl"></div>

            <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center">
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#39A900] text-white shadow-lg shadow-[#39A900]/20">
                    <i class="fa-solid fa-pen-to-square text-2xl"></i>
                </div>

                <div>
                    <div class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-[#90EE90]">
                        <span class="h-2 w-2 rounded-full bg-[#39A900]"></span>
                        Inventario institucional
                    </div>

                    <h2 class="text-2xl font-extrabold text-white sm:text-3xl">
                        Editar equipo
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-slate-300">
                        Modifica la información del equipo #{{ $id }}.
                    </p>
                </div>
            </div>
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5" role="alert">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 text-lg text-rose-600"></i>

                    <div>
                        <h3 class="font-bold text-rose-800">
                            No se pudo actualizar el equipo
                        </h3>

                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                <i class="fa-solid fa-circle-exclamation text-lg text-rose-600"></i>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if (session('success'))
            <div
                class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                <i class="fa-solid fa-circle-check text-lg text-emerald-600"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Formulario --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5 sm:px-8">
                <h3 class="text-base font-extrabold text-[#081B28]">
                    Editar datos del equipo
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Los campos marcados con
                    <span class="text-rose-500">*</span>
                    son obligatorios.
                </p>
            </div>

            <form action="{{ route('equipos.update', $id) }}" method="POST" class="space-y-6 p-6 sm:p-8">

                @csrf
                @method('PUT')

                <div class="grid gap-6 sm:grid-cols-2">

                    {{-- Nombre --}}
                    <div class="sm:col-span-2">
                        <label for="name" class="mb-2 block text-sm font-bold text-[#081B28]">
                            Nombre del equipo <span class="text-rose-500">*</span>
                        </label>

                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fa-solid fa-laptop"></i>
                            </div>

                            <input type="text" name="name" id="name" value="{{ $nombre }}"
                                placeholder="Ej. Kit de desarrollo web" maxlength="150" required autocomplete="off"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-4 text-sm text-[#081B28] outline-none transition placeholder:text-slate-400 focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10 {{ $errors->has('name') ? 'border-rose-400' : '' }}">
                        </div>

                        @error('name')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Marca --}}
                    <div>
                        <label for="brand" class="mb-2 block text-sm font-bold text-[#081B28]">
                            Marca
                        </label>

                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fa-solid fa-tag"></i>
                            </div>

                            <input type="text" name="brand" id="brand" value="{{ $marca }}"
                                placeholder="Ej. SENA, HP, Dell" maxlength="100" autocomplete="off"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-4 text-sm text-[#081B28] outline-none transition placeholder:text-slate-400 focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10">
                        </div>

                        @error('brand')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipo de equipo --}}
                    <div>
                        <label for="equipment_type" class="mb-2 block text-sm font-bold text-[#081B28]">
                            Tipo de equipo <span class="text-rose-500">*</span>
                        </label>

                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fa-solid fa-list"></i>
                            </div>

                            <select name="equipment_type" id="equipment_type" required
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-11 text-sm text-[#081B28] outline-none transition focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10">

                                <option value="">Selecciona un tipo</option>

                                @foreach (['Equipo de cómputo', 'Equipo de laboratorio', 'Herramienta', 'Equipo de oficina', 'Equipo electrónico', 'Otro'] as $t)
                                    <option value="{{ $t }}" @selected($tipo === $t)>
                                        {{ $t }}
                                    </option>
                                @endforeach

                            </select>

                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        @error('equipment_type')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Ambiente --}}
                    <div class="sm:col-span-2">
                        <label for="environment_id" class="mb-2 block text-sm font-bold text-[#081B28]">
                            Ambiente asignado <span class="text-rose-500">*</span>
                        </label>

                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fa-solid fa-door-open"></i>
                            </div>

                            <select name="environment_id" id="environment_id" required
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-11 text-sm text-[#081B28] outline-none transition focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10 {{ $errors->has('environment_id') ? 'border-rose-400' : '' }}">

                                <option value="">Selecciona el ambiente</option>

                                @forelse (($ambientes ?? []) as $amb)
                                    <option value="{{ data_get($amb, 'id') }}" @selected((string) $ambienteId === (string) data_get($amb, 'id'))>
                                        {{ data_get($amb, 'nombre', data_get($amb, 'name', 'Ambiente sin nombre')) }}
                                    </option>
                                @empty
                                    <option value="" disabled>
                                        No hay ambientes disponibles
                                    </option>
                                @endforelse

                            </select>

                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        @error('environment_id')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror

                        <p class="mt-2 text-xs text-slate-500">
                            Selecciona el ambiente de formación al que pertenece este equipo.
                        </p>
                    </div>

                </div>

                {{-- Acciones --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

                    <a href="{{ route('equipos.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50 hover:text-[#081B28]">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        Cancelar
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-[#39A900]/20 transition hover:-translate-y-0.5 hover:bg-[#2e8800] hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-[#39A900]/20">
                        <i class="fa-solid fa-floppy-disk text-sm"></i>
                        Guardar cambios
                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection
