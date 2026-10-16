<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AdminSena - Panel de Administración')</title>
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
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-slate-50 text-slate-800 antialiased selection:bg-[#39A900] selection:text-white">
    <div class="flex h-screen overflow-hidden bg-slate-50">
        {{-- Aside / Menú lateral --}}
        @include('Includes.Aside')
        {{-- Área principal de trabajo --}}
        <div class="flex flex-1 flex-col overflow-hidden">
            {{-- Contenido con Scroll Independiente --}}
            <main class="flex-1 overflow-y-auto p-6 md:p-8">
                
                {{-- Mensajes Flash (Notificaciones de sesión) --}}
                @if (session('success'))
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-[#39A900]/30 bg-[#39A900]/10 p-4 text-xs font-semibold text-[#1e5a00] shadow-sm">
                        <i class="fa-solid fa-circle-check text-base text-[#39A900]"></i>
                        <span class="flex-1">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-xs font-semibold text-red-800 shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation text-base text-red-500"></i>
                        <span class="flex-1">{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div> @endif
                {{-- Contenido principal inyectado desde las vistas --}}
                @yield('contenido')
            </main>
        </div>
    </div>
    {{-- Área para modales u otros componentes fuera del flujo normal --}}
    @yield('modals')
    @stack('scripts')
</body>
</html>
