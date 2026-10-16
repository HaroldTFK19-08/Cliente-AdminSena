@extends('Layouts.Admin')

@section('title', 'Editar programa - AdminSena')

@section('contenido')
    <div class="min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">

            <a href="{{ route('programas.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-[#247A16]">
                <i class="fa-solid fa-arrow-left"></i>
                Volver a programas
            </a>

            <div class="mb-6 mt-4">
                <h1 class="text-3xl font-bold text-[#081B28]">Editar programa</h1>
                <p class="mt-2 text-slate-500">
                    Actualiza la información del programa de formación.
                </p>
            </div>

            @if (session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('programas.update', data_get($programa, 'id')) }}" method="POST"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf
                @method('PUT')

                <div class="p-6 sm:p-8">
                    <div class="mb-6 flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-[#247A16]">
                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-[#081B28]">Datos del programa</h2>
                            <p class="text-sm text-slate-500">
                                ID del programa: {{ data_get($programa, 'id', '—') }}
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="nombre" class="mb-2 block text-sm font-semibold text-slate-700">
                                Nombre del programa
                            </label>
                            <input id="nombre" name="nombre" type="text" required
                                value="{{ old('nombre', data_get($programa, 'nombre')) }}"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:border-[#39A900] focus:ring-4 focus:ring-green-100">
                        </div>

                        <div>
                            <label for="codigo_programa" class="mb-2 block text-sm font-semibold text-slate-700">
                                Código del programa
                            </label>
                            <input id="codigo_programa" name="codigo_programa" type="text" required
                                value="{{ old('codigo_programa', data_get($programa, 'codigo_programa')) }}"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:border-[#39A900] focus:ring-4 focus:ring-green-100">
                        </div>

                        <div>
                            <label for="nivel_programa" class="mb-2 block text-sm font-semibold text-slate-700">
                                Nivel de formación
                            </label>
                            @php
                                $nivelActual = old('nivel_programa', data_get($programa, 'nivel_programa'));
                                $niveles = [
                                    'Tecnico' => 'Técnico',
                                    'Tecnologo' => 'Tecnólogo',
                                    'Auxiliar' => 'Auxiliar',
                                    'Operario' => 'Operario',
                                    'Especializacion' => 'Especialización',
                                ];
                            @endphp

                            <select id="nivel_programa" name="nivel_programa" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 outline-none focus:border-[#39A900] focus:ring-4 focus:ring-green-100">
                                @foreach ($niveles as $valor => $etiqueta)
                                    <option value="{{ $valor }}" @selected($nivelActual === $valor)>
                                        {{ $etiqueta }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="area_id" class="mb-2 block text-sm font-semibold text-slate-700">
                                Área de formación
                            </label>
                            <select id="area_id" name="area_id" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 outline-none focus:border-[#39A900] focus:ring-4 focus:ring-green-100">
                                <option value="">Selecciona un área</option>

                                @foreach ($areas ?? [] as $area)
                                    <option value="{{ data_get($area, 'id') }}" @selected((string) old('area_id', data_get($programa, 'area_id')) === (string) data_get($area, 'id'))>
                                        {{ data_get($area, 'nombre', 'Área sin nombre') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-col-reverse justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:px-8">
                    <a href="{{ route('programas.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 font-semibold text-slate-600 hover:bg-slate-100">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 font-semibold text-white hover:bg-[#2f8d00]">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
