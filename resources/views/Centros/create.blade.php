@extends('Layouts.Admin')

@section('page-title', 'Registrar centro de formación')

@section('contenido')
    <div class="mx-auto max-w-3xl space-y-6">
        <div>
            <a href="{{ route('centros.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-[#39A900]">
                <i class="fa-solid fa-arrow-left"></i>
                Volver a centros
            </a>
            <h1 class="mt-4 text-2xl font-bold text-gray-900">
                Registrar centro de formación
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Ingresa la información del nuevo centro.
            </p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-5">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]">
                    <i class="fa-solid fa-building text-xl"></i>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900">Datos del centro</h2>
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
            <form action="{{ route('centros.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="nombre" class="mb-2 block text-sm font-semibold text-gray-700">
                        Nombre del centro
                    </label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                        placeholder="Ej. Centro de Formación Tecnológica SENA" required maxlength="255"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
                </div>
                <div>
                    <label for="direccion" class="mb-2 block text-sm font-semibold text-gray-700">
                        Dirección
                    </label>
                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}"
                        placeholder="Ej. Carrera 7 # 100-20, Bogotá" required maxlength="255"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
                </div>
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('centros.index') }}"
                        class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2e8800]">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar centro
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
