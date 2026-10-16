@extends('Layouts.Admin')

@section('title', 'Editar ambiente')

@section('contenido')
@php
    // Normaliza la respuesta de la API (lista directa o paginada)
    if (is_object($centros) && property_exists($centros, 'data')) {
        $centros = (array) $centros->data;
    } elseif (is_array($centros) && isset($centros['data']) && is_array($centros['data'])) {
        $centros = $centros['data'];
    } elseif (!is_array($centros)) {
        $centros = [];
    }

    $get = function ($item, $keys, $default = null) {
        foreach ((array) $keys as $key) {
            $value = data_get($item, $key);
            if ($value !== null && $value !== '') return $value;
        }
        return $default;
    };

    $centroActual = $get($ambiente, ['trainingcenter_id', 'centro_id', 'id_centro']);

    $tiposAmbiente = ['Software', 'TICS', 'Laboratorio', 'Cocina'];
    $tipoActual = (string) $get($ambiente, ['tipo_ambiente', 'tipo', 'type', 'TIPO'], '');
@endphp

<div class="mx-auto max-w-3xl space-y-6">

    <div>
        <a href="{{ route('ambientes.show', data_get($ambiente, 'id')) }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-[#39A900]">
            <i class="fa-solid fa-arrow-left"></i>
            Volver al detalle
        </a>

        <h1 class="mt-4 text-2xl font-bold text-gray-900">
            Editar ambiente
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Actualiza los datos del ambiente seleccionado.
        </p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center gap-4 border-b border-gray-100 p-6 sm:p-8">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]">
                <i class="fa-solid fa-pen-to-square text-xl"></i>
            </div>

            <div>
                <h2 class="font-semibold text-gray-900">Información del ambiente</h2>
                <p class="mt-1 text-sm text-gray-500">
                    ID del ambiente: {{ data_get($ambiente, 'id') }}
                </p>
            </div>
        </div>

        <form action="{{ route('ambientes.update', data_get($ambiente, 'id')) }}" method="POST"
            class="space-y-5 p-6 sm:p-8">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="nombre" class="mb-2 block text-sm font-semibold text-gray-700">
                    Nombre del ambiente
                </label>

                <input type="text" id="nombre" name="nombre"
                    value="{{ old('nombre', $get($ambiente, ['nombre', 'nombre_ambiente', 'name'])) }}"
                    placeholder="Nombre del ambiente de formación" required maxlength="255"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
            </div>

            <div>
                <label for="trainingcenter_id" class="mb-2 block text-sm font-semibold text-gray-700">
                    Centro de formación
                </label>

                <select id="trainingcenter_id" name="trainingcenter_id" required
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
                    <option value="">-- Selecciona un centro --</option>
                    @foreach ($centros as $centro)
                        <option value="{{ data_get($centro, 'id') }}"
                            {{ old('trainingcenter_id', $centroActual) == data_get($centro, 'id') ? 'selected' : '' }}>
                            {{ data_get($centro, 'nombre', 'Centro sin nombre') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="tipo_ambiente" class="mb-2 block text-sm font-semibold text-gray-700">
                        Tipo de ambiente
                    </label>

                    <select id="tipo_ambiente" name="tipo_ambiente"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
                        <option value="">-- Selecciona el tipo --</option>
                        @foreach ($tiposAmbiente as $tipo)
                            <option value="{{ $tipo }}"
                                {{ old('tipo_ambiente', $tipoActual) === $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="capacidad" class="mb-2 block text-sm font-semibold text-gray-700">
                        Capacidad máxima
                    </label>

                    <input type="number" id="capacidad" name="capacidad"
                        value="{{ old('capacidad', $get($ambiente, ['capacidad', 'aforo', 'capacity'])) }}"
                        min="1" max="9999" placeholder="Ej. 30"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                <a href="{{ route('ambientes.show', data_get($ambiente, 'id')) }}"
                    class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Cancelar
                </a>

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2e8800]">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
