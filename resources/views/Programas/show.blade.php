@extends('Layouts.Admin')

@section('title', 'Detalle del programa - AdminSena')

@section('contenido')
    <div class="min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-5xl">

            <a href="{{ route('programas.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-[#247A16]">
                <i class="fa-solid fa-arrow-left"></i>
                Volver al listado
            </a>

            <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="bg-[#081B28] px-6 py-8 text-white sm:px-8">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white/10">
                                <i class="fa-solid fa-graduation-cap text-3xl text-[#A1E887]"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-300">Detalle del programa</p>
                                <h1 class="mt-1 text-2xl font-bold">
                                    {{ data_get($programa, 'nombre', 'Programa sin nombre') }}
                                </h1>
                                <p class="mt-2 text-sm text-slate-300">
                                    Código: {{ data_get($programa, 'codigo_programa', '—') }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('programas.edit', data_get($programa, 'id')) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-4 py-3 font-semibold text-white hover:bg-[#2f8d00]">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Editar programa
                        </a>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <h2 class="mb-6 text-lg font-bold text-[#081B28]">Información general</h2>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="rounded-xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Identificador</p>
                            <p class="mt-2 text-lg font-bold text-[#081B28]">
                                #{{ data_get($programa, 'id', '—') }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Código del programa</p>
                            <p class="mt-2 text-lg font-bold text-[#081B28]">
                                {{ data_get($programa, 'codigo_programa', '—') }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Nivel de formación</p>
                            <p class="mt-2">
                                <span
                                    class="inline-flex rounded-full bg-blue-50 px-3 py-2 text-sm font-semibold text-blue-700">
                                    {{ data_get($programa, 'nivel_programa', 'No especificado') }}
                                </span>
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Área de formación</p>
                            <p class="mt-2 text-lg font-bold text-[#081B28]">
                                <i class="fa-solid fa-building mr-2 text-[#39A900]"></i>
                                {{ data_get($programa, 'area.nombre', 'Sin área asignada') }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Fecha de creación</p>
                            <p class="mt-2 font-semibold text-[#081B28]">
                                {{ data_get($programa, 'created_at') ? \Illuminate\Support\Carbon::parse(data_get($programa, 'created_at'))->format('d/m/Y H:i') : '—' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Última actualización</p>
                            <p class="mt-2 font-semibold text-[#081B28]">
                                {{ data_get($programa, 'updated_at') ? \Illuminate\Support\Carbon::parse(data_get($programa, 'updated_at'))->format('d/m/Y H:i') : '—' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
