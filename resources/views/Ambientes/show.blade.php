@extends('Layouts.Admin')

@section('title', 'Detalle del ambiente')

@section('contenido')
@php
    $get = function ($item, $keys, $default = null) {
        foreach ((array) $keys as $key) {
            $value = data_get($item, $key);
            if ($value !== null && $value !== '') return $value;
        }
        return $default;
    };

    $nombre    = (string) $get($ambiente, ['nombre', 'nombre_ambiente', 'name'], 'Ambiente sin nombre');
    $tipo      = (string) $get($ambiente, ['tipo_ambiente', 'tipo', 'type', 'TIPO'], '');
    $capacidad = (int) $get($ambiente, ['capacidad', 'aforo', 'capacity'], 0);

    $centroNombre = function () use ($get, $ambiente) {
        $anidado = $get($ambiente, ['trainingcenter.nombre', 'trainingcenter.name', 'centro.nombre'], null);
        if ($anidado) return (string) $anidado;

        $directo = $get($ambiente, ['centro_nombre', 'nombre_centro'], null);
        if ($directo) return (string) $directo;

        $id = $get($ambiente, ['trainingcenter_id', 'centro_id', 'id_centro'], null);
        return ($id !== null && $id !== '') ? 'Centro #' . $id : 'Centro no asociado';
    };

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
        <a href="{{ route('ambientes.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-[#39A900]">
            <i class="fa-solid fa-arrow-left"></i>
            Volver a ambientes
        </a>

        <div class="mt-4 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detalle del ambiente</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Consulta la información del ambiente de formación.
                </p>
            </div>

            <a href="{{ route('ambientes.edit', data_get($ambiente, 'id')) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2e8800]">
                <i class="fa-solid fa-pen-to-square"></i>
                Editar ambiente
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        {{-- Cabecera --}}
        <div class="bg-[#101D2D] px-6 py-8 sm:px-8">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-[#83DB55]">
                    <i class="fa-solid fa-door-open text-3xl"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-300">
                        Ambiente de formación #{{ data_get($ambiente, 'id') }}
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-white sm:text-2xl">
                        {{ $nombre }}
                    </h2>

                    <p class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-300">
                        <span class="inline-flex items-center gap-2">
                            <i class="fa-solid fa-building-columns text-[#83DB55]"></i>
                            {{ $centroNombre() }}
                        </span>

                        @if ($tipo)
                            <span class="inline-flex items-center gap-2">
                                <i class="fa-solid fa-tags text-[#83DB55]"></i>
                                {{ $tipo }}
                            </span>
                        @endif

                        <span class="inline-flex items-center gap-2">
                            <i class="fa-solid fa-users text-[#83DB55]"></i>
                            Capacidad: {{ number_format($capacidad) }}
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
                        {{ data_get($ambiente, 'id', 'No disponible') }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                        <i class="fa-solid fa-door-open"></i>
                    </div>
                    <p class="text-sm text-gray-500">Nombre del ambiente</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $nombre }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <p class="text-sm text-gray-500">Tipo de ambiente</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $tipo ?: 'No disponible' }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <p class="text-sm text-gray-500">Capacidad máxima</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ number_format($capacidad) }} {{ $capacidad === 1 ? 'persona' : 'personas' }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <p class="text-sm text-gray-500">Centro de formación</p>
                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $centroNombre() }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <p class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fa-regular fa-calendar-plus"></i>
                        Fecha de registro
                    </p>
                    <p class="mt-2 font-semibold text-gray-900">
                        {{ $fechaDe($get($ambiente, 'created_at')) }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                    <p class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Última actualización
                    </p>
                    <p class="mt-2 font-semibold text-gray-900">
                        {{ $fechaDe($get($ambiente, 'updated_at')) }}
                    </p>
                </div>
            </div>

            <div class="mt-8 flex justify-end border-t border-gray-100 pt-6">
                <a href="{{ route('ambientes.index') }}"
                    class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Volver al listado
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
