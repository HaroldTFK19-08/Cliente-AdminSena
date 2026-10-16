@extends('Layouts.Admin')
@section('title', 'Registrar Equipo - AdminSena')
@section('contenido')
    <div class="mx-auto max-w-3xl space-y-6">
        {{-- Encabezado --}}
        <div class="relative overflow-hidden rounded-3xl bg-[#081B28] p-6 shadow-lg sm:p-8">
            <div class="absolute -right-10 -top-16 h-48 w-48 rounded-full bg-[#39A900]/20 blur-3xl"></div>
            <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center">
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#39A900] text-white shadow-lg shadow-[#39A900]/20">
                    <i class="fa-solid fa-laptop text-2xl"></i>
                </div>
                <div>
                    <div class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-[#90EE90]">
                        <span class="h-2 w-2 rounded-full bg-[#39A900]"></span>
                        Inventario institucional
                    </div>
                    <h2 class="text-2xl font-extrabold text-white sm:text-3xl">Registrar nuevo equipo
                    </h2>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-300">
                        Completa la información del equipo para incorporarlo al inventario
                        institucional de AdminSena.
                    </p>
                </div>
            </div>
        </div>
        {{-- Errores de validación --}}
        @if (isset($errors) && $errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5" role="alert">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 text-lg text-rose-600"></i>
                    <div>
                        <h3 class="font-bold text-rose-800">No se pudo registrar el equipo</h3>
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
        {{-- Formulario --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-5 sm:px-8">
                <h3 class="text-base font-extrabold text-[#081B28]">Datos del equipo</h3>
                <p class="mt-1 text-sm text-slate-500">Los campos marcados con <span class="text-rose-500">\*</span> son
                    obligatorios.</p>
            </div>
            <form action="{{ route('equipos.store') }}" method="POST" class="space-y-6 p-6 sm:p-8">
                @csrf
                <div class="grid gap-6 sm:grid-cols-2">
                    {{-- Nombre --}}
                    <div class="sm:col-span-2">
                        <label for="nombre" class="mb-2 block text-sm font-bold text-[#081B28]">
                            Nombre del equipo <span class="text-rose-500">\*</span>
                        </label>
                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fa-solid fa-laptop"></i>
                            </div>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                                placeholder="Ej. Computador HP ProBook 440" maxlength="150" required autocomplete="off"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-4 text-sm text-[#081B28] outline-none transition placeholder:text-slate-400 focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10 {{ $errors?->has('nombre') ?? false ? 'border-rose-400' : '' }}">
                        </div>
                        @error('nombre')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Marca --}}
                    <div>
                        <label for="marca" class="mb-2 block text-sm font-bold text-[#081B28]">Marca</label>
                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fa-solid fa-tag"></i>
                            </div>
                            <input type="text" name="marca" id="marca" value="{{ old('marca') }}"
                                placeholder="Ej. HP, Dell, Lenovo" maxlength="100" autocomplete="off"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-4 text-sm text-[#081B28] outline-none transition placeholder:text-slate-400 focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10">
                        </div>
                        @error('marca')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Modelo --}}
                    <div>
                        <label for="modelo" class="mb-2 block text-sm font-bold text-[#081B28]">Modelo</label>
                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fa-solid fa-cube"></i>
                            </div>
                            <input type="text" name="modelo" id="modelo" value="{{ old('modelo') }}"
                                placeholder="Ej. ProBook 440 G9" maxlength="100" autocomplete="off"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-4 text-sm text-[#081B28] outline-none transition placeholder:text-slate-400 focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10">
                        </div>
                        @error('modelo')
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
                                @foreach (['Equipo de cómputo', 'Equipo de redes', 'Instrumento', 'Simulador'] as $equipmentType)
                                    <option value="{{ $equipmentType }}" @selected(old('equipment_type') === $equipmentType)>
                                        {{ $equipmentType }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('equipment_type')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- Ambiente --}}
                    <div class="sm:col-span-2">
                        <label for="ambiente_id" class="mb-2 block text-sm font-bold text-[#081B28]">
                            Ambiente asignado <span class="text-rose-500">\*</span>
                        </label>
                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fa-solid fa-door-open"></i>
                            </div>
                            <select name="ambiente_id" id="ambiente_id" required
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-11 text-sm text-[#081B28] outline-none transition focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10 {{ $errors?->has('ambiente_id') ?? false ? 'border-rose-400' : '' }}">
                                <option value="">Selecciona el ambiente</option>
                                @forelse (($ambientes ?? []) as $ambiente)
                                    <option value="{{ data_get($ambiente, 'id') }}" @selected((string) old('ambiente_id') === (string) data_get($ambiente, 'id'))>
                                        {{ data_get($ambiente, 'nombre', data_get($ambiente, 'name', 'Ambiente sin nombre')) }}
                                    </option>
                                @empty
                                    <option value="" disabled>No hay ambientes
                                        disponibles</option>
                                @endforelse
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('ambiente_id')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Acciones --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                        <a href="{{ route('equipos.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50 hover:text-[#081B28]">
                            <i class="fa-solid fa-arrow-left text-xs"></i> Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-[#39A900]/20 transition hover:-translate-y-0.5 hover:bg-[#2e8800] hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-[#39A900]/20">
                            <i class="fa-solid fa-floppy-disk text-sm"></i> Registrar equipo
                        </button>
                    </div>
            </form>
        </div>
    </div>
@endsection
