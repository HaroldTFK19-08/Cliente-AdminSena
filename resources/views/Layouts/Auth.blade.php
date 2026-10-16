<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AdminSena')</title>
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

<body class="min-h-screen overflow-x-hidden overflow-y-auto bg-[#F6F8F5] text-slate-800 antialiased selection:bg-[#39A900] selection:text-white">
    <div class="grid min-h-screen lg:grid-cols-[1fr_1.1fr]">
        {{-- ======== Panel institucional ======== --}}
        <aside class="relative hidden overflow-hidden bg-[#081B28] p-12 lg:flex lg:flex-col xl:p-16">
            <div class="pointer-events-none absolute inset-0 opacity-[0.07]"
                style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 48px 48px; mask-image: radial-gradient(ellipse at 20% 30%, black 10%, transparent 70%);"></div>
            <div class="pointer-events-none absolute -left-24 -top-24 h-96 w-96 rounded-full bg-[#39A900]/25 blur-[100px]"></div>
            <div class="pointer-events-none absolute -bottom-32 -right-16 h-[26rem] w-[26rem] rounded-full bg-[#39A900]/15 blur-[100px]"></div>

            {{-- Marca --}}
            <a href="{{ route('publico.inicio') }}" class="relative flex items-center gap-3.5">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl border border-white/10 bg-white/[0.06] p-2">
                    <img src="{{ asset('logoSena.svg') }}" alt="Logo SENA" class="h-full w-full object-contain">
                </span>
                <span class="leading-none">
                    <span class="block text-2xl font-extrabold tracking-tight text-white">Admin<span class="text-[#39A900]">Sena</span></span>
                    <span class="mt-1.5 block text-[9px] font-semibold uppercase tracking-[0.19em] text-slate-400">Gestión institucional</span>
                </span>
            </a>

            {{-- Mensaje principal --}}
            <div class="relative my-auto py-12" data-aparece>
                <h2 class="max-w-md text-4xl font-extrabold leading-[1.12] tracking-tight text-white xl:text-[2.75rem]">
                    @yield('lema', 'Toda la formación del SENA en un solo lugar.')
                </h2>
                <p class="mt-5 max-w-md text-base leading-8 text-slate-300">
                    @yield('sublema', 'Convocatorias, fichas, competencias, ambientes y equipos, gestionados desde una plataforma.')
                </p>

                {{-- Tarjeta de vidrio con lo que ofrece la plataforma --}}
                <div class="mt-10 max-w-md rounded-2xl border border-white/10 bg-white/[0.05] p-5 backdrop-blur-xl">
                    <ul class="space-y-4">
                        @foreach ([['fa-bullhorn', 'Convocatorias abiertas', 'Revisa fechas, cupos y requisitos.'], ['fa-file-signature', 'Inscripción en línea', 'Sigue el estado de tu proceso.'], ['fa-graduation-cap', 'Tu formación al día', 'Consulta tu ficha y tus resultados.']] as [$icono, $titulo, $texto])
                            <li class="flex items-center gap-4">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#39A900]/15 text-[#65D62E]">
                                    <i class="fa-solid {{ $icono }}"></i>
                                </span>
                                <span>
                                    <span class="block text-sm font-bold text-white">{{ $titulo }}</span>
                                    <span class="block text-xs text-slate-400">{{ $texto }}</span>
                                </span>
                            </li> @endforeach
                    </ul>
                </div>

                {{-- Frases que rotan --}}
                <div class="mt-8
        max-w-md" id="frasesAuth">
    @foreach ([['La formación gratuita del SENA llega a todo el país.', 'Servicio Nacional de Aprendizaje'], ['Revisa las fechas de cada convocatoria y no dejes pasar el cierre.', 'Consejo para aspirantes'], ['Tu ficha, tus competencias y tus resultados, siempre a la mano.', 'Para aprendices e instructores']] as [$frase, $autor])
        <figure data-frase class="{{ $loop->first ? '' : 'hidden' }}">
            <blockquote class="flex gap-3 text-sm leading-7 text-slate-300">
                <i class="fa-solid fa-quote-left mt-1 text-[#39A900]"></i>
                <span>{{ $frase }}</span>
            </blockquote>
            <figcaption class="mt-2 pl-7 text-xs font-semibold text-slate-500">{{ $autor }}</figcaption>
        </figure>
    @endforeach
    <div class="mt-4 flex gap-1.5 pl-7">
        @for ($i = 0; $i < 3; $i++)
            <span data-punto-frase
                class="h-1.5 rounded-full transition-all {{ $i === 0 ? 'w-6 bg-[#39A900]' : 'w-1.5 bg-white/20' }}"></span>
        @endfor
    </div>
    </div>
    </div>

    <p class="relative text-xs text-slate-500">© {{ now()->year }} Servicio Nacional de Aprendizaje SENA</p>
    </aside>

    {{-- ======== Formulario ======== --}}
    <main class="relative flex min-h-screen min-w-0 flex-col overflow-visible px-5 py-8 sm:px-10 lg:px-16">
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('publico.inicio') }}" class="flex items-center gap-2.5 lg:hidden">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#081B28] p-2">
                    <img src="{{ asset('logoSena.svg') }}" alt="Logo SENA" class="h-full w-full object-contain">
                </span>
                <span class="text-lg font-extrabold text-[#081B28]">Admin<span class="text-[#39A900]">Sena</span></span>
            </a>
            <nav class="ml-auto flex items-center gap-1 text-sm font-medium text-slate-500">
                <a href="{{ route('publico.inicio') }}"
                    class="hidden rounded-xl px-3 py-2 transition hover:bg-white hover:text-[#081B28] sm:inline-flex">Inicio</a>
                <a href="{{ route('publico.ofertas') }}"
                    class="hidden rounded-xl px-3 py-2 transition hover:bg-white hover:text-[#081B28] sm:inline-flex">Convocatorias</a>
                <a href="{{ route('publico.noticias') }}"
                    class="hidden rounded-xl px-3 py-2 transition hover:bg-white hover:text-[#081B28] sm:inline-flex">Noticias</a>
                <a href="{{ route('publico.inicio') }}"
                    class="inline-flex items-center gap-2 rounded-xl px-3 py-2 transition hover:bg-white hover:text-[#081B28] sm:hidden">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Sitio
                </a>
            </nav>
        </div>

        <div class="mx-auto flex w-full flex-1 items-center py-10 @yield('ancho', 'max-w-md')">
            <div class="w-full" data-aparece="2">
                @yield('contenido')
            </div>
        </div>
    </main>
    </div>
    <script>
        // Rotación de frases del panel institucional
        (function() {
            const frases = document.querySelectorAll('[data-frase]');
            const puntos = document.querySelectorAll('[data-punto-frase]');
            if (frases.length < 2 || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            let actual = 0;
            setInterval(function() {
                frases[actual].classList.add('hidden');
                puntos[actual].className = 'h-1.5 w-1.5 rounded-full bg-white/20 transition-all';
                actual = (actual + 1) % frases.length;
                frases[actual].classList.remove('hidden');
                puntos[actual].className = 'h-1.5 w-6 rounded-full bg-[#39A900] transition-all';
            }, 5000);
        })();

        // Botón con estado de carga al enviar cualquier formulario
        document.querySelectorAll('form').forEach(function(formulario) {
            formulario.addEventListener('submit', function() {
                const boton = formulario.querySelector('button[type="submit"]');
                if (!boton) return;
                boton.disabled = true;
                boton.classList.add('opacity-80', 'cursor-wait');
                boton.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> ' + (boton.dataset
                    .cargando || 'Procesando...');
            });
        });
    </script>
    @stack('scripts')
    </body>

</html>
