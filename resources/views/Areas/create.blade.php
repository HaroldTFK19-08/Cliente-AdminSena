@extends('Layouts.Admin')

@section('title', 'Registrar Área - AdminSena')
@section('page-title', 'Registrar Área')

@section('contenido')
    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Encabezado --}}
        <div class="relative overflow-hidden rounded-3xl bg-[#081B28] p-6 shadow-lg sm:p-8">
            <div class="absolute -right-10 -top-16 h-48 w-48 rounded-full bg-[#39A900]/20 blur-3xl"></div>

            <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center">
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#39A900] text-white shadow-lg shadow-[#39A900]/20">
                    <i class="fa-solid fa-layer-group text-2xl"></i>
                </div>

                <div>
                    <div class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-[#90EE90]">
                        <span class="h-2 w-2 rounded-full bg-[#39A900]"></span>
                        Gestión académica
                    </div>

                    <h2 class="text-2xl font-extrabold text-white sm:text-3xl">
                        Registrar nueva área
                    </h2>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-300">
                        Completa la información del área de formación para incorporarla al catálogo institucional de
                        AdminSena.
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
                        <h3 class="font-bold text-rose-800">
                            No se pudo registrar el área
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

        {{-- Mensaje de error del controlador --}}
        @if (session('error'))
            <div class="flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                <i class="fa-solid fa-circle-exclamation text-lg text-rose-600"></i>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{-- Formulario --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5 sm:px-8">
                <h3 class="text-base font-extrabold text-[#081B28]">
                    Información del área
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Los campos marcados son obligatorios.
                </p>
            </div>

            <form action="{{ route('areas.post') }}" method="POST" class="space-y-7 p-6 sm:p-8">
                @csrf

                {{-- Nombre del área --}}
                <div>
                    <label for="nombre" class="mb-2 block text-sm font-bold text-[#081B28]">
                        Nombre del área
                        <span class="text-rose-500">*</span>
                    </label>

                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>

                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                            placeholder="Ej. Desarrollo de Software" maxlength="100" required autocomplete="off"
                            aria-describedby="nombre-ayuda"
                            class="w-full rounded-xl border bg-slate-50 py-3.5 pl-11 pr-4 text-sm text-[#081B28] outline-none transition placeholder:text-slate-400 focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10 {{ $errors?->has('nombre') ?? false ? 'border-rose-400' : 'border-slate-200' }}">
                    </div>

                    <p id="nombre-ayuda" class="mt-2 text-xs leading-5 text-slate-500">
                        Ingresa un nombre claro que identifique el área de formación.
                    </p>

                    @error('nombre')
                        <p class="mt-2 flex items-center gap-2 text-xs font-medium text-rose-600">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- Centro de formación --}}
                <div>
                    <label for="centro_id" class="mb-2 block text-sm font-bold text-[#081B28]">
                        Centro de formación <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <select name="trainingcenter_id" id="trainingcenter_id" required
                            class="w-full appearance-none rounded-xl border bg-slate-50 py-3.5 pl-11 pr-11 text-sm text-[#081B28] outline-none transition focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10 {{ $errors?->has('centro_id') ?? false ? 'border-rose-400' : 'border-slate-200' }}">
                            <option value="">Selecciona un centro de formación</option>

                            @forelse (($centros ?? []) as $centro)
                                <option value="{{ data_get($centro, 'id') }}" @selected((string) old('trainingcenter_id') === (string) data_get($centro, 'id'))>
                                    {{ data_get($centro, 'nombre', data_get($centro, 'nombre_centro', data_get($centro, 'name', 'Centro sin nombre'))) }}
                                </option>
                            @empty
                                <option value="" disabled>No hay centros de formación disponibles</option>
                            @endforelse
                        </select>

                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        Selecciona el centro al que pertenecerá esta área.
                    </p>

                    @error('centro_id')
                        <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Información complementaria --}}
                <div class="flex items-start gap-3 rounded-2xl border border-[#39A900]/15 bg-[#39A900]/5 p-4">
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#278000] shadow-sm">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>

                    <div>
                        <p class="text-sm font-bold text-[#081B28]">
                            Antes de guardar
                        </p>

                        <p class="mt-1 text-xs leading-5 text-slate-600">
                            Verifica que el nombre sea correcto y que el área no se encuentre registrada previamente.
                        </p>
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('areas.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50 hover:text-[#081B28]">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        Cancelar
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-[#39A900]/20 transition hover:-translate-y-0.5 hover:bg-[#2e8800] hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-[#39A900]/20">
                        <i class="fa-solid fa-floppy-disk text-sm"></i>
                        Registrar área
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
