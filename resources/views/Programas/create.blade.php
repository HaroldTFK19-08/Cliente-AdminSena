@extends('Layouts.Admin')

@section('title', 'Registrar programa - AdminSena')

@section('contenido')
    <div class="min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">

            <div class="mb-6">
                <a href="{{ route('programas.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-[#247A16]">
                    <i class="fa-solid fa-arrow-left"></i>
                    Volver a programas
                </a>

                <h1 class="mt-4 text-3xl font-bold text-[#081B28]">Registrar programa</h1>
                <p class="mt-2 text-slate-500">
                    Completa la información del nuevo programa de formación.
                </p>
            </div>

            @if (session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                    <p class="mb-2 font-semibold">Revisa los siguientes campos:</p>
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('programas.store') }}" method="POST"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf

                <div class="border-b border-slate-200 bg-white p-6 sm:p-8">
                    <div class="mb-6 flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-[#247A16]">
                            <i class="fa-solid fa-graduation-cap text-lg"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-[#081B28]">Información del programa</h2>
                            <p class="text-sm text-slate-500">Los campos marcados son obligatorios.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="nombre" class="mb-2 block text-sm font-semibold text-slate-700">
                                Nombre del programa <span class="text-red-500">*</span>
                            </label>
                            <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required
                                placeholder="Ej. Programación web"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:border-[#39A900] focus:ring-4 focus:ring-green-100">
                        </div>

                        <div>
                            <label for="codigo_programa" class="mb-2 block text-sm font-semibold text-slate-700">
                                Código del programa <span class="text-red-500">*</span>
                            </label>
                            <input id="codigo_programa" name="codigo_programa" type="text"
                                value="{{ old('codigo_programa') }}" required placeholder="Ej. PROG-001"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:border-[#39A900] focus:ring-4 focus:ring-green-100">
                        </div>

                        <div>
                            <label for="nivel_programa" class="mb-2 block text-sm font-semibold text-slate-700">
                                Nivel de formación <span class="text-red-500">*</span>
                            </label>
                            <select id="nivel_programa" name="nivel_programa" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 outline-none focus:border-[#39A900] focus:ring-4 focus:ring-green-100">
                                <option value="">Selecciona un nivel</option>
                                <option value="Tecnico" @selected(old('nivel_programa') === 'Tecnico')>Técnico</option>
                                <option value="Tecnologo" @selected(old('nivel_programa') === 'Tecnologo')>Tecnólogo</option>
                                <option value="Auxiliar" @selected(old('nivel_programa') === 'Auxiliar')>Auxiliar</option>
                                <option value="Operario" @selected(old('nivel_programa') === 'Operario')>Operario</option>
                                <option value="Especializacion" @selected(old('nivel_programa') === 'Especializacion')>Especialización</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="area_id" class="mb-2 block text-sm font-semibold text-slate-700">
                                Área de formación <span class="text-red-500">*</span>
                            </label>
                            <select id="area_id" name="area_id" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 outline-none focus:border-[#39A900] focus:ring-4 focus:ring-green-100">
                                <option value="">Selecciona un área</option>
                                @foreach ($areas ?? [] as $area)
                                    <option value="{{ data_get($area, 'id') }}" @selected((string) old('area_id') === (string) data_get($area, 'id'))>
                                        {{ data_get($area, 'nombre', 'Área sin nombre') }}
                                    </option>
                                @endforeach
                            </select>
                            @if (empty($areas))
                                <p class="mt-2 text-sm text-amber-600">
                                    No se encontraron áreas. Verifica la conexión con la API.
                                </p>
                            @endif
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
                        Guardar programa
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
