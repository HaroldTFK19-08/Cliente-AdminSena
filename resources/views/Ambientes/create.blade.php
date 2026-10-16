@extends('Layouts.Admin')

@section('title', 'Registrar ambiente')

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

    $tiposAmbiente = ['Software', 'TICS', 'Laboratorio', 'Cocina'];
@endphp

<div class="mx-auto max-w-3xl space-y-6">

    <div>
        <a href="{{ route('ambientes.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-[#39A900]">
            <i class="fa-solid fa-arrow-left"></i>
            Volver a ambientes
        </a>

        <h1 class="mt-4 text-2xl font-bold text-gray-900">
            Registrar ambiente
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Ingresa la información del nuevo ambiente de formación.
        </p>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">

        <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-5">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]">
                <i class="fa-solid fa-door-open text-xl"></i>
            </div>

            <div>
                <h2 class="font-semibold text-gray-900">Datos del ambiente</h2>
                <p class="text-sm text-gray-500">Información general y ubicación</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (empty($centros))
            <div class="mb-5 flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                <i class="fa-solid fa-triangle-exclamation mt-0.5 text-lg"></i>
                <p>
                    No hay centros de formación disponibles para asociar.
                    <a href="{{ route('centros.create') }}" class="font-semibold underline underline-offset-2">Registrar un centro</a>
                    antes de crear un ambiente.
                </p>
            </div>
        @endif

        <form action="{{ route('ambientes.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="nombre" class="mb-2 block text-sm font-semibold text-gray-700">
                    Nombre del ambiente
                </label>

                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                    placeholder="Ej. Aula 101 / Taller de Electrónica" required maxlength="255"
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
                            {{ old('trainingcenter_id') == data_get($centro, 'id') ? 'selected' : '' }}>
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
                            <option value="{{ $tipo }}" {{ old('tipo_ambiente') === $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="capacidad" class="mb-2 block text-sm font-semibold text-gray-700">
                        Capacidad máxima
                    </label>

                    <input type="number" id="capacidad" name="capacidad" value="{{ old('capacidad') }}"
                        min="1" max="9999" placeholder="Ej. 30"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                <a href="{{ route('ambientes.index') }}"
                    class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Cancelar
                </a>

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2e8800]">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar ambiente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
