@extends('Layouts.Admin')

@section('title', 'Detalle del usuario')

@section('contenido')
@php
    $get = function ($item, $keys, $default = null) {
        foreach ((array) $keys as $key) {
            $value = data_get($item, $key);
            if ($value !== null && $value !== '') return $value;
        }
        return $default;
    };

    // Nombre completo
    $partes = array_filter([
        data_get($usuario, 'nombre_1'),
        data_get($usuario, 'nombre_2'),
        data_get($usuario, 'apellido_1'),
        data_get($usuario, 'apellido_2'),
    ], fn ($v) => $v !== null && $v !== '');
    $nombreCompleto = $partes ? implode(' ', $partes) : 'Usuario sin nombre';

    $iniciales = mb_strtoupper(mb_substr((string) data_get($usuario, 'nombre_1', ''), 0, 1, 'UTF-8'), 'UTF-8')
               . mb_strtoupper(mb_substr((string) data_get($usuario, 'apellido_1', ''), 0, 1, 'UTF-8'), 'UTF-8');
    $iniciales = $iniciales ?: 'U';

    $rol = (string) $get($usuario, ['rol'], 'Sin rol');
    $foto = (string) Vista::archivo($get($usuario, ['foto_perfil'], ''));

    // Perfil según el rol
    $teacher    = data_get($usuario, 'teacher');
    $apprentice = data_get($usuario, 'apprentice');
    $aspirant   = data_get($usuario, 'aspirant');

    $fechaDe = function ($v) {
        if (! $v) return 'No disponible';
        try {
            return \Illuminate\Support\Carbon::parse($v)->format('d/m/Y H:i');
        } catch (\Throwable $e) {
            return (string) $v;
        }
    };
@endphp

<div class="mx-auto max-w-5xl space-y-6">

    <div>
        <a href="{{ route('usuarios.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-[#39A900]">
            <i class="fa-solid fa-arrow-left"></i>
            Volver a usuarios
        </a>

        <div class="mt-4 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detalle del usuario</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Consulta la información del usuario.
                </p>
            </div>
            <a href="{{ route('usuarios.edit', data_get($usuario, 'id')) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2e8800]">
                <i class="fa-solid fa-pen-to-square"></i>
                Editar usuario
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        {{-- Cabecera --}}
        <div class="bg-[#101D2D] px-6 py-8 sm:px-8">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                @if ($foto)
                    <img src="{{ $foto }}" alt="{{ $nombreCompleto }}"
                        class="h-16 w-16 shrink-0 rounded-2xl object-cover ring-2 ring-white/20">
                @else
                    <div
                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-2xl font-extrabold text-[#83DB55] ring-2 ring-white/10">
                        {{ $iniciales }}
                    </div>
                @endif

                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-300">
                        Usuario #{{ data_get($usuario, 'id') }}
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-white sm:text-2xl">
                        {{ $nombreCompleto }}
                    </h2>

                    <p class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-300">
                        <span class="inline-flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-[#83DB55]"></i>
                            {{ $get($usuario, ['email'], 'Sin email') }}
                        </span>

                        <span class="inline-flex items-center gap-2">
                            <i class="fa-solid fa-fingerprint text-[#83DB55]"></i>
                            {{ $get($usuario, ['tipo_identificacion'], '') }}
                            {{ $get($usuario, ['identificacion'], 'N/A') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Cuerpo --}}
        <div class="p-6 sm:p-8">
            <h3 class="mb-5 text-base font-bold text-gray-900">
                Información general
            </h3>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                        <i class="fa-solid fa-hashtag"></i>
                    </div>
                    <p class="text-sm text-gray-500">Identificador</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ data_get($usuario, 'id', 'No disponible') }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <p class="text-sm text-gray-500">Nombre completo</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $nombreCompleto }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <p class="text-sm text-gray-500">Tipo de identificación</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $get($usuario, ['tipo_identificacion'], 'No disponible') }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                        <i class="fa-solid fa-fingerprint"></i>
                    </div>
                    <p class="text-sm text-gray-500">Número de identificación</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $get($usuario, ['identificacion'], 'No disponible') }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <p class="text-sm text-gray-500">Correo electrónico</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $get($usuario, ['email'], 'No disponible') }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <p class="text-sm text-gray-500">Rol</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $rol }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <p class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fa-regular fa-calendar-plus"></i>
                        Fecha de registro
                    </p>
                    <p class="mt-2 font-semibold text-gray-900">
                        {{ $fechaDe($get($usuario, 'created_at')) }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <p class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Última actualización
                    </p>
                    <p class="mt-2 font-semibold text-gray-900">
                        {{ $fechaDe($get($usuario, 'updated_at')) }}
                    </p>
                </div>
            </div>

            {{-- Información de instructor --}}
            @if ($teacher)
                <h3 class="mb-5 mt-10 text-base font-bold text-gray-900">
                    Información de instructor
                </h3>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <p class="text-sm text-gray-500">Especialidad</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $get($teacher, ['especialidad'], 'No disponible') }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <p class="text-sm text-gray-500">Tipo de instructor</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $get($teacher, ['tipo_instructor'], 'No disponible') }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                        <p class="text-sm text-gray-500">Fecha de inicio</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $fechaDe($get($teacher, ['fecha_inicio'])) }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i class="fa-solid fa-calendar-flag"></i>
                        </div>
                        <p class="text-sm text-gray-500">Fecha de fin</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $get($teacher, ['fecha_fin']) ? $fechaDe($get($teacher, ['fecha_fin'])) : 'No definida' }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5 sm:col-span-2">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <p class="text-sm text-gray-500">Área</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $get($teacher, ['area.nombre'], 'No disponible') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Información de aprendiz --}}
            @if ($apprentice)
                <h3 class="mb-5 mt-10 text-base font-bold text-gray-900">
                    Información de aprendiz
                </h3>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <p class="text-sm text-gray-500">Estado</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $get($apprentice, ['estado'], 'No disponible') }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                            <i class="fa-solid fa-hashtag"></i>
                        </div>
                        <p class="text-sm text-gray-500">Identificador de aprendiz</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $get($apprentice, ['id'], 'No disponible') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Información de aspirante --}}
            @if ($aspirant)
                <h3 class="mb-5 mt-10 text-base font-bold text-gray-900">
                    Información de aspirante
                </h3>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <p class="text-sm text-gray-500">EPS</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $get($aspirant, ['eps'], 'No disponible') }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                            <i class="fa-solid fa-hashtag"></i>
                        </div>
                        <p class="text-sm text-gray-500">Identificador de aspirante</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $get($aspirant, ['id'], 'No disponible') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="mt-8 flex justify-end border-t border-gray-100 pt-6">
                <a href="{{ route('usuarios.index') }}"
                    class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Volver al listado
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
