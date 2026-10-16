@extends('Layouts.Admin')
@section('contenido')
    @php
        $id = data_get($area, 'id');
        $nombre = data_get($area, 'nombre', '');
        $centroActual = data_get($area, 'trainingcenter.id', data_get($area, 'trainingcenter_id'));
    @endphp
    <div class="min-h-screen bg-[#f6f8f5] px-5 py-8 sm:px-8 lg:px-10">
        <div class="mx-auto max-w-5xl">
            {{-- Navegación --}}
            <div class="mb-8 flex items-center gap-2 text-sm">
                <a href="{{ route('areas.index') }}" class="text-gray-500 transition hover:text-[#39A900]">
                    Áreas
                </a>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>

                <a href="{{ route('areas.show', $id) }}" class="text-gray-500 transition hover:text-[#39A900]">
                    Detalle
                </a>

                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="m9 18 6-6-6-6" />
                </svg>

                <span class="font-medium text-gray-800">Editar área</span>
            </div>

            {{-- Encabezado --}}
            <header class="mb-8">
                <div class="mb-3 flex items-center gap-2">
                    <span class="h-1 w-8 rounded-full bg-[#39A900]"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#328d08]">
                        Gestión académica
                    </span>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-[#17251b] sm:text-4xl">
                    Editar área
                </h1>

                <p class="mt-2 text-sm leading-6 text-gray-500 sm:text-base">
                    Modifica la información del área de formación y su centro asociado.
                </p>
            </header>

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 shrink-0 text-red-600" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4m0 4h.01" />
                        </svg>

                        <div>
                            <h2 class="font-semibold text-red-800">
                                No se pudo actualizar el área
                            </h2>

                            <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Formulario --}}
            <form action="{{ route('areas.update', $id) }}" method="POST"
                class="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-[0_4px_24px_rgba(20,37,26,0.04)]">

                @csrf
                @method('PUT')

                {{-- Cabecera de la tarjeta --}}
                <div class="border-b border-gray-100 px-6 py-6 sm:px-8">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#edf8e8] text-[#328d08]">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L9 17l-4 1 1-4Z" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-[#17251b]">
                                Información del área
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Los campos con <span class="text-red-500">*</span> son obligatorios.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Campos --}}
                <div class="space-y-7 px-6 py-7 sm:px-8 sm:py-8">

                    {{-- ID del área --}}
                    <div>
                        <label for="area_id" class="mb-2 block text-sm font-semibold text-gray-700">
                            Identificador
                        </label>

                        <input type="text" id="area_id" value="#{{ $id }}" disabled
                            class="w-full cursor-not-allowed rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-500 outline-none sm:max-w-xs">

                        <p class="mt-2 text-xs text-gray-400">
                            El identificador no se puede modificar.
                        </p>
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="mb-2 block text-sm font-semibold text-gray-700">
                            Nombre del área <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $nombre) }}"
                            placeholder="Ej. Tecnología" maxlength="150" required autocomplete="off"
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 hover:border-gray-300 focus:border-[#39A900] focus:ring-4 focus:ring-[#39A900]/10">

                        @error('nombre')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <p class="mt-2 text-xs text-gray-400">
                            Escribe el nombre con el que se identificará el área de formación.
                        </p>
                    </div>

                    {{-- Centro de formación --}}
                    <div>
                        <label for="trainingcenter_id" class="mb-2 block text-sm font-semibold text-gray-700">
                            Centro de formación <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">
                            <select name="trainingcenter_id" id="trainingcenter_id" required
                                class="w-full appearance-none rounded-xl border border-gray-200 bg-white px-4 py-3 pr-11 text-sm text-gray-800 outline-none transition hover:border-gray-300 focus:border-[#39A900] focus:ring-4 focus:ring-[#39A900]/10">

                                <option value="">Selecciona un centro de formación</option>

                                @foreach ($centros as $centro)
                                    <option value="{{ data_get($centro, 'id') }}" @selected((string) old('trainingcenter_id', $centroActual) === (string) data_get($centro, 'id'))>
                                        {{ data_get($centro, 'nombre', 'Centro sin nombre') }}
                                    </option>
                                @endforeach
                            </select>

                            <svg class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"
                                width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </div>

                        @error('trainingcenter_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <p class="mt-2 text-xs text-gray-400">
                            Selecciona el centro al que pertenece esta área.
                        </p>
                    </div>

                    {{-- Nota informativa --}}
                    <div class="flex items-start gap-3 rounded-xl border border-[#dcebd5] bg-[#f5faf1] p-4">
                        <svg class="mt-0.5 shrink-0 text-[#328d08]" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4m0-4h.01" />
                        </svg>

                        <div>
                            <p class="text-sm font-semibold text-[#285d1b]">
                                Ten en cuenta
                            </p>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                Verifica que el nombre y el centro de formación sean correctos antes de guardar los cambios.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Acciones --}}
                <div
                    class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50/70 px-6 py-5 sm:flex-row sm:justify-end sm:px-8">
                    <a href="{{ route('areas.show', $id) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#328d08] focus:outline-none focus:ring-4 focus:ring-[#39A900]/20">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z" />
                            <path d="M17 21v-8H7v8" />
                            <path d="M7 3v5h8" />
                        </svg>
                        Guardar cambios
                    </button>
                </div>
            </form>

            {{-- Pie --}}
            <div class="mt-6 text-center text-xs text-gray-400">
                AdminSena · Gestión de áreas de formación
            </div>
        </div>
    </div>
@endsection
