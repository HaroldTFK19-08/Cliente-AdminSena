@extends('Layouts.Admin')

@section('page-title', 'Detalle del centro')

@section('contenido')
    <div class="mx-auto max-w-5xl space-y-6">

        <div>
            <a href="{{ route('centros.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-[#39A900]">
                <i class="fa-solid fa-arrow-left"></i>
                Volver a centros
            </a>

            <div class="mt-4 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detalle del centro</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Consulta la información del centro de formación.
                    </p>
                </div>

                <a href="{{ route('centros.edit', data_get($centro, 'id')) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2e8800]">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Editar centro
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="bg-[#101D2D] px-6 py-8 sm:px-8">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-[#83DB55]">
                        <i class="fa-solid fa-building text-3xl"></i>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-300">
                            Centro de formación #{{ data_get($centro, 'id') }}
                        </p>
                        <h2 class="mt-1 text-xl font-bold text-white sm:text-2xl">
                            {{ data_get($centro, 'nombre', 'Centro sin nombre') }}
                        </h2>
                        <p class="mt-2 flex items-center gap-2 text-sm text-gray-300">
                            <i class="fa-solid fa-location-dot text-[#83DB55]"></i>
                            {{ data_get($centro, 'direccion', 'Sin dirección registrada') }}
                        </p>
                    </div>
                </div>
            </div>

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
                            {{ data_get($centro, 'id', 'No disponible') }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <p class="text-sm text-gray-500">Nombre del centro</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ data_get($centro, 'nombre', 'No disponible') }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5 sm:col-span-2">
                        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <p class="text-sm text-gray-500">Dirección</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ data_get($centro, 'direccion', 'No disponible') }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <p class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fa-regular fa-calendar-plus"></i>
                            Fecha de registro
                        </p>
                        <p class="mt-2 font-semibold text-gray-900">
                            {{ data_get($centro, 'created_at') ? \Illuminate\Support\Carbon::parse(data_get($centro, 'created_at'))->format('d/m/Y H:i') : 'No disponible' }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">
                        <p class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            Última actualización
                        </p>
                        <p class="mt-2 font-semibold text-gray-900">
                            {{ data_get($centro, 'updated_at') ? \Illuminate\Support\Carbon::parse(data_get($centro, 'updated_at'))->format('d/m/Y H:i') : 'No disponible' }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end border-t border-gray-100 pt-6">
                    <a href="{{ route('centros.index') }}"
                        class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
