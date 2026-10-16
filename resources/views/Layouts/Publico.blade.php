<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AdminSena - SENA')</title>
    <meta name="description" content="Ofertas de formación, programas y noticias de los centros del SENA.">
    <link rel="icon" href="{{ asset('logoSena.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="overflow-y-hidden bg-white text-slate-800 antialiased selection:bg-[#39A900] selection:text-white">
    {{-- Barra de navegación: transparente sobre la portada y sólida al bajar --}}
    <header id="barraPublica" data-solida="{{ $__env->hasSection('barra-solida') ? '1' : '' }}" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
        <nav class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-6 px-5 sm:px-8">
            <a href="{{ route('publico.inicio') }}" class="group flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/10 bg-white/[0.06] p-2 transition group-hover:border-[#39A900]/40">
                    <img src="{{ asset('logoSena.svg') }}" alt="Logo SENA" class="h-full w-full object-contain">
                </span>
                <span class="leading-none">
                    <span class="block text-xl font-extrabold tracking-tight text-white">Admin<span class="text-[#39A900]">Sena</span></span>
                    <span class="mt-1 block text-[9px] font-semibold uppercase tracking-[0.19em] text-slate-400">Formación SENA</span>
                </span>
            </a>

            <div class="hidden items-center gap-1 text-sm font-medium text-slate-300 lg:flex">
                @foreach ([[route('publico.inicio'), 'Inicio', request()->routeIs('publico.inicio')], [route('publico.ofertas'), 'Convocatorias', request()->routeIs('publico.ofertas', 'publico.oferta')], [route('publico.inicio') . '#como-funciona', 'Cómo inscribirte', false], [route('publico.inicio') . '#programas', 'Programas', false], [route('publico.noticias'), 'Noticias', request()->routeIs('publico.noticias', 'publico.noticia')]] as [$enlace, $texto, $activo])
                    <a href="{{ $enlace }}" class="rounded-lg px-3 py-2 transition {{ $activo ? 'bg-white/[0.08] text-white' : 'hover:bg-white/[0.06] hover:text-white' }}">{{ $texto }}</a> @endforeach
            </div>

            <div class="flex
        items-center gap-2">
    @if (session('api_token'))
        <a href="{{ route('home') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-[#39A900] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#39A900]/20 transition hover:bg-[#2e8800]">
            <i class="fa-solid fa-gauge-high"></i> Ir a mi panel
        </a>
    @else
        <a href="{{ route('login') }}"
            class="hidden rounded-xl px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10 sm:inline-flex">
            Iniciar sesión
        </a>
        <a href="{{ route('registro') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-[#39A900] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#39A900]/20 transition hover:-translate-y-0.5 hover:bg-[#2e8800]">
            Crear cuenta
        </a>
    @endif
    </div>
    </nav>
    </header>

    <main>
        @yield('contenido')
    </main>

    <footer class="relative overflow-hidden bg-[#061620] text-slate-400">
        <div class="pointer-events-none absolute -top-24 left-1/3 h-64 w-64 rounded-full bg-[#39A900]/10 blur-3xl">
        </div>
        <div class="relative mx-auto grid max-w-7xl gap-10 px-5 py-16 sm:px-8 md:grid-cols-[2fr_1fr_1fr_1fr]">
            <div>
                <div class="flex items-center gap-3">
                    <span
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/10 bg-white/[0.06] p-2">
                        <img src="{{ asset('logoSena.svg') }}" alt="" class="h-full w-full object-contain">
                    </span>
                    <span class="text-xl font-extrabold text-white">Admin<span class="text-[#39A900]">Sena</span></span>
                </div>
                <p class="mt-5 max-w-sm text-sm leading-7">
                    Plataforma para consultar las convocatorias del SENA, inscribirte a programas de formación
                    y seguir tu proceso desde un solo lugar.
                </p>
            </div>
            <div>
                <p class="text-sm font-bold text-white">Formación</p>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('publico.ofertas') }}"
                            class="transition hover:text-[#65D62E]">Convocatorias</a></li>
                    <li><a href="{{ route('publico.inicio') }}#programas"
                            class="transition hover:text-[#65D62E]">Programas</a></li>
                    <li><a href="{{ route('publico.inicio') }}#centros" class="transition hover:text-[#65D62E]">Centros
                            de formación</a></li>
                </ul>
            </div>
            <div>
                <p class="text-sm font-bold text-white">Aspirantes</p>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('publico.inicio') }}#como-funciona"
                            class="transition hover:text-[#65D62E]">Cómo inscribirte</a></li>
                    <li><a href="{{ route('publico.noticias') }}" class="transition hover:text-[#65D62E]">Noticias</a>
                    </li>
                </ul>
            </div>
            <div>
                <p class="text-sm font-bold text-white">Tu cuenta</p>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('login') }}" class="transition hover:text-[#65D62E]">Iniciar sesión</a></li>
                    <li><a href="{{ route('registro') }}" class="transition hover:text-[#65D62E]">Crear cuenta</a></li>
                </ul>
            </div>
        </div>
        <div class="relative border-t border-white/[0.06]">
            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-5 py-6 text-xs sm:flex-row sm:justify-between sm:px-8">
                <p>© {{ now()->year }} Servicio Nacional de Aprendizaje SENA</p>
                <p>AdminSena · Gestión institucional</p>
            </div>
        </div>
    </footer>

    <script>
        // La barra se vuelve sólida cuando el usuario baja por la página
        (function() {
            const barra = document.getElementById('barraPublica');
            const actualizar = () => {
                const abajo = barra.dataset.solida === '1' || window.scrollY > 40;
                barra.classList.toggle('bg-[#081B28]/95', abajo);
                barra.classList.toggle('backdrop-blur-md', abajo);
                barra.classList.toggle('shadow-lg', abajo);
                barra.classList.toggle('shadow-black/10', abajo);
            };
            window.addEventListener('scroll', actualizar, {
                passive: true
            });
            actualizar();
        })();
    </script>
    @stack('scripts')
    </body>

</html>
