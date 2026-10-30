@php
    $usuarioSesion = session('usuario');
    $conSesion = (bool) session('api_token');
    // Título de la barra superior: el de la pestaña sin el sufijo " - AdminSena"
    $tituloPagina = trim(preg_replace('/\s*-\s*AdminSena.*$/u', '', $__env->yieldContent('title', 'Inicio')));
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AdminSena - Panel de Administración')</title>
    <link rel="icon" href="{{ asset('logoSena.svg') }}">
    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body data-panel class="h-full bg-slate-50 text-slate-800 antialiased selection:bg-[#39A900] selection:text-white">
    <a href="#contenido"
        class="sr-only z-[60] rounded-lg bg-white px-4 py-2 text-sm font-semibold text-azul-900 shadow focus:not-sr-only focus:fixed focus:left-4 focus:top-4">
        Saltar al contenido
    </a>

    <div class="flex h-screen overflow-hidden">
        {{-- Fondo oscuro detrás del menú en celulares --}}
        <div data-menu-fondo class="fixed inset-0 z-30 hidden bg-azul-950/60 backdrop-blur-sm lg:hidden"></div>

        {{-- Aside / Menú lateral --}}
        @include('Includes.Aside')

        {{-- Área principal de trabajo --}}
        <div class="flex min-w-0 flex-1 flex-col overflow-hidden">
            {{-- Barra superior --}}
            <header
                class="z-20 flex h-16 shrink-0 items-center gap-3 border-b border-slate-200/80 bg-white/85 px-4 backdrop-blur-md sm:px-6 md:px-8">
                <button type="button" data-menu-abrir aria-label="Abrir menú" aria-expanded="false"
                    class="btn-icono -ml-1 lg:hidden">
                    <i class="fa-solid fa-bars text-base"></i>
                </button>

                <p class="min-w-0 flex-1 truncate text-sm font-semibold text-azul-900">{{ $tituloPagina }}</p>

                @if ($conSesion)
                    <span class="hidden items-center gap-2 rounded-full bg-sena-50 px-3 py-1 text-xs font-semibold text-sena-700 sm:inline-flex">
                        <i class="fa-solid {{ data_get($usuarioSesion, 'rol') === 'Admin' ? 'fa-shield-halved' : 'fa-user' }} text-[11px]"></i>
                        {{ data_get($usuarioSesion, 'rol', 'Usuario') }}
                    </span>
                    <a href="{{ route('home') }}" title="Mi inicio"
                        class="avatar h-9 w-9 rounded-full bg-gradient-to-br from-[#39A900] to-[#247A16] text-xs text-white ring-2 ring-white">
                        @if ($foto = Vista::archivo(data_get($usuarioSesion, 'foto_perfil')))
                            <img src="{{ $foto }}" alt="" class="h-full w-full object-cover">
                        @else
                            {{ Vista::iniciales($usuarioSesion) }}
                        @endif
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-secundario px-3.5 py-2">
                        <i class="fa-solid fa-right-to-bracket text-xs"></i>
                        <span class="hidden sm:inline">Iniciar sesión</span>
                    </a>
                    <a href="{{ route('registro') }}" class="btn-primario px-3.5 py-2">
                        <i class="fa-solid fa-user-plus text-xs"></i>
                        <span class="hidden sm:inline">Crear cuenta</span>
                    </a>
                @endif
            </header>

            {{-- Contenido con scroll independiente --}}
            <main id="contenido" tabindex="-1" class="flex-1 overflow-y-auto outline-none">
                <div class="mx-auto w-full max-w-[90rem] p-4 sm:p-6 md:p-8">
                    @yield('contenido')
                </div>
            </main>
        </div>
    </div>

    {{-- Avisos de sesión como notificaciones flotantes --}}
    <div aria-live="polite"
        class="pointer-events-none fixed inset-x-4 bottom-4 z-50 flex flex-col items-end gap-3 sm:inset-x-auto sm:right-6 sm:w-96">
        @foreach (['success' => ['fa-circle-check', 'text-sena-500', 'border-sena-200', 'bg-sena-500', 'Listo'], 'error' => ['fa-circle-exclamation', 'text-red-500', 'border-red-200', 'bg-red-500', 'Algo salió mal']] as $tipo => [$icono, $color, $borde, $barra, $encabezado])
            @if (session($tipo))
                <div data-aviso role="{{ $tipo === 'error' ? 'alert' : 'status' }}" class="aviso {{ $borde }}">
                    <i class="fa-solid {{ $icono }} mt-0.5 text-lg {{ $color }}"></i>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-azul-900">{{ $encabezado }}</p>
                        <p class="mt-0.5 text-slate-600">{{ session($tipo) }}</p>
                    </div>
                    <button type="button" data-aviso-cerrar aria-label="Cerrar aviso"
                        class="btn-icono absolute right-2 top-2 h-8 w-8">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <span data-aviso-barra class="absolute inset-x-0 bottom-0 h-0.5 origin-left {{ $barra }}"></span>
                </div>
            @endif
        @endforeach
    </div>

    {{-- Confirmación antes de eliminar (la usan los formularios con data-confirmar) --}}
    <dialog data-dialogo-confirmar class="dialogo" aria-labelledby="dialogoTitulo">
        <div class="p-6 sm:p-7">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-lg text-red-600">
                <i class="fa-solid fa-trash"></i>
            </span>
            <h2 id="dialogoTitulo" class="mt-5 text-lg font-bold text-azul-900">Confirmar eliminación</h2>
            <p data-dialogo-mensaje class="mt-2 text-sm leading-6 text-slate-600"></p>
        </div>
        <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
            <button type="button" data-dialogo-cancelar class="btn-secundario py-2.5">Cancelar</button>
            <button type="button" data-dialogo-aceptar class="btn-peligro-solido py-2.5">
                <i class="fa-solid fa-trash text-xs"></i> Sí, eliminar
            </button>
        </div>
    </dialog>

    @yield('modals')
    @stack('scripts')
</body>

</html>
