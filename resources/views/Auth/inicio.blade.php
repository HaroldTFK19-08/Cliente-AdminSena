@extends('Layouts.Auth')

@section('title', 'Iniciar sesión - AdminSena')
@section('lema', 'Bienvenido de nuevo a AdminSena.')
@section('sublema', 'Ingresa para gestionar la formación, revisar convocatorias y seguir tu proceso en el SENA.')

@section('contenido')
    <div class="rounded-3xl border border-gray-200 bg-white p-7 shadow-xl shadow-[#081B28]/5 sm:p-10">
        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#E8F7DF] text-xl text-[#278000]">
            <i class="fa-solid fa-right-to-bracket"></i>
        </div>
        <h1 class="mt-6 text-3xl font-extrabold tracking-tight text-[#081B28]">Iniciar sesión</h1>
        <p class="mt-2 text-sm text-slate-500">Ingresa con el correo y la contraseña de tu cuenta.</p>

        <div class="mt-7">
            @include('Includes.mensajes')
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">Correo electrónico</label>
                <div class="relative">
                    <i class="fa-regular fa-envelope pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                        placeholder="nombre@correo.com"
                        class="w-full rounded-xl border border-gray-300 bg-gray-50/60 py-3.5 pl-11 pr-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10 {{ session('error') ? 'border-red-300 bg-red-50/40' : '' }}">
                </div>
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">Contraseña</label>
                <div class="relative">
                    <i class="fa-solid fa-lock pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="password" id="password" name="password" required maxlength="8" autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border border-gray-300 bg-gray-50/60 py-3.5 pl-11 pr-12 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10">
                    <button type="button" data-ver-clave="password" aria-label="Mostrar contraseña"
                        class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-gray-400 transition hover:text-[#081B28]">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                <p id="avisoMayus" class="mt-2 hidden items-center gap-2 text-xs font-medium text-amber-600">
                    <i class="fa-solid fa-triangle-exclamation"></i> Tienes activadas las mayúsculas.
                </p>
            </div>

            <button type="submit" data-cargando="Ingresando..."
                class="group flex w-full items-center justify-center gap-2 rounded-xl bg-[#39A900] py-4 text-sm font-bold text-white shadow-lg shadow-[#39A900]/25 transition hover:-translate-y-0.5 hover:bg-[#2e8800]">
                Ingresar
                <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
            </button>
        </form>

        <div class="my-8 flex items-center gap-4 text-xs text-gray-400">
            <span class="h-px flex-1 bg-gray-200"></span>
            ¿Primera vez en AdminSena?
            <span class="h-px flex-1 bg-gray-200"></span>
        </div>

        <a href="{{ route('registro') }}"
            class="flex w-full items-center justify-center gap-2 rounded-xl border border-gray-300 py-3.5 text-sm font-bold text-[#081B28] transition hover:border-[#39A900] hover:bg-[#E8F7DF]/50">
            <i class="fa-solid fa-user-plus text-[#39A900]"></i>
            Crear una cuenta
        </a>
    </div>
@endsection

@include('Auth._ver-clave')

@push('scripts')
    <script>
        // Aviso de bloqueo de mayúsculas en la contraseña
        document.getElementById('password').addEventListener('keyup', function(evento) {
            const activo = evento.getModifierState && evento.getModifierState('CapsLock');
            const aviso = document.getElementById('avisoMayus');
            aviso.classList.toggle('hidden', !activo);
            aviso.classList.toggle('flex', activo);
        });
    </script>
@endpush
