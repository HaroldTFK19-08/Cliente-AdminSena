@extends('Layouts.Publico')

@section('title', 'AdminSena - Formación SENA')

@section('contenido')
    @php
        $hoy = now()->toDateString();

        // Solo lo publicado se muestra en el sitio (los datos llegan de la API tal cual)
        $ofertas = collect($ofertas ?? [])->filter(fn($o) => data_get($o, 'publicada'))->values()->all();
        $noticias = collect($noticias ?? [])->filter(fn($n) => data_get($n, 'publicada') || data_get($n, 'estado') === 'Publicado')->take(4)->values()->all();
        $programas = $programas ?? [];
        $centros = $centros ?? [];
        $cuposOfrecidos = collect($ofertas)->sum('capacidad');

        // Convocatoria destacada: la próxima en cerrar
        $proxima = collect($ofertas)
            ->filter(fn($o) => substr((string) data_get($o, 'fecha_fin_convocatoria'), 0, 10) >= $hoy)
            ->sortBy('fecha_fin_convocatoria')
            ->first() ?? ($ofertas[0] ?? null);

        $etapas = $proxima ? array_values(array_filter([
            ['Abre la convocatoria', data_get($proxima, 'fecha_convocatoria'), 'fa-door-open'],
            ['Cierran las inscripciones', data_get($proxima, 'fecha_fin_convocatoria'), 'fa-lock'],
            ['Primera prueba', data_get($proxima, 'fecha_primera_prueba'), 'fa-pen'],
            ['Segunda prueba', data_get($proxima, 'fecha_segunda_prueba'), 'fa-pen-to-square'],
            ['Seleccionados', data_get($proxima, 'fecha_seleccionados'), 'fa-trophy'],
        ], fn($e) => filled($e[1]))) : [];
        $actual = collect($etapas)->search(fn($e) => substr($e[1], 0, 10) >= $hoy);
        $actual = $actual === false ? count($etapas) : $actual;
        $diasCierre = $proxima ? (int) now()->startOfDay()->diffInDays(\Illuminate\Support\Carbon::parse(data_get($proxima, 'fecha_fin_convocatoria')), false) : null;
    @endphp

    {{-- ============ PORTADA ============ --}}
    <section class="relative overflow-hidden bg-[#081B28] pb-28 pt-32 lg:pb-36 lg:pt-40">
        {{-- Fondo: rejilla + brillos verdes --}}
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]"
            style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 56px 56px; mask-image: radial-gradient(ellipse at 30% 40%, black 20%, transparent 70%);"></div>
        <div class="pointer-events-none absolute -left-32 top-20 h-[28rem] w-[28rem] rounded-full bg-[#39A900]/25 blur-[110px]"></div>
        <div class="pointer-events-none absolute -right-20 bottom-0 h-96 w-96 rounded-full bg-[#39A900]/15 blur-[100px]"></div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-5 sm:px-8 lg:grid-cols-[1.15fr_1fr]">
            <div data-aparece>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3.5 py-1.5 text-xs font-semibold text-[#90EE90] backdrop-blur">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#39A900] opacity-60"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-[#39A900]"></span>
                    </span>
                    {{ count($ofertas) === 1 ? '1 convocatoria abierta' : count($ofertas) . ' convocatorias abiertas' }} · {{ now()->year }}
                </span>

                <h1 class="mt-7 text-4xl font-extrabold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-[3.6rem]">
                    Tu formación técnica y tecnológica empieza aquí
                </h1>
                <p class="mt-6 max-w-xl text-base leading-8 text-slate-300 sm:text-lg">
                    Conoce las ofertas de formación gratuitas de los centros del SENA, revisa las fechas de cada
                    convocatoria y crea tu cuenta para inscribirte en minutos.
                </p>

                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="#ofertas"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-7 py-4 text-sm font-bold text-white shadow-xl shadow-[#39A900]/25 transition hover:-translate-y-0.5 hover:bg-[#2e8800]">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Explorar ofertas
                    </a>
                    <a href="{{ route('registro') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/15 bg-white/5 px-7 py-4 text-sm font-bold text-white backdrop-blur transition hover:bg-white/10">
                        <i class="fa-solid fa-user-plus"></i>
                        Crear mi cuenta gratis
                    </a>
                </div>

                {{-- Cifras --}}
                <dl class="mt-12 grid max-w-lg grid-cols-3 gap-6 border-t border-white/10 pt-8">
                    @foreach ([['Programas', count($programas)], ['Centros', count($centros)], ['Cupos abiertos', $cuposOfrecidos]] as [$texto, $valor])
                        <div>
                            <dt class="text-xs font-medium text-slate-400">{{ $texto }}</dt>
                            <dd class="mt-1 text-3xl font-extrabold text-white tabular-nums">{{ number_format($valor, 0, ',', '.') }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Tarjeta: cronograma de la próxima convocatoria --}}
            <div data-aparece="2" class="relative">
                <div class="absolute -inset-4 rounded-[2rem] bg-gradient-to-br from-[#39A900]/30 via-transparent to-transparent blur-2xl"></div>
                <div class="relative rounded-3xl border border-white/10 bg-white/[0.06] p-6 shadow-2xl backdrop-blur-xl sm:p-8">
                    @if ($proxima)
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#90EE90]">Próxima convocatoria</p>
                                <h2 class="mt-2 text-xl font-bold leading-snug text-white">{{ data_get($proxima, 'program.nombre') }}</h2>
                                <p class="mt-1 text-sm text-slate-400">{{ data_get($proxima, 'program.area.trainingcenter.nombre', 'Centro de formación SENA') }}</p>
                            </div>
                            @if (!is_null($diasCierre) && $diasCierre >= 0)
                                <div class="shrink-0 rounded-2xl bg-[#39A900] px-3 py-2 text-center text-white shadow-lg shadow-[#39A900]/30">
                                    <p class="text-2xl font-extrabold leading-none tabular-nums">{{ $diasCierre }}</p>
                                    <p class="mt-1 text-[10px] font-semibold uppercase tracking-wide">{{ $diasCierre === 1 ? 'día' : 'días' }}</p>
                                </div>
                            @endif
                        </div>

                        <ol class="mt-8">
                            @foreach ($etapas as $i => [$texto, $fecha, $icono])
                                @php $hecha = $i < $actual; $enCurso = $i === $actual; @endphp
                                <li class="relative flex gap-4 pb-5 last:pb-0">
                                    @unless ($loop->last)
                                        <span class="absolute left-[17px] top-9 h-[calc(100%-2rem)] w-0.5 {{ $hecha ? 'bg-[#39A900]' : 'bg-white/10' }}"></span>
                                    @endunless
                                    <span class="relative z-10 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-xs
                                        {{ $hecha ? 'bg-[#39A900] text-white' : ($enCurso ? 'bg-white text-[#278000] ring-4 ring-[#39A900]/30' : 'bg-white/[0.06] text-slate-400') }}">
                                        <i class="fa-solid {{ $hecha ? 'fa-check' : $icono }}"></i>
                                    </span>
                                    <div class="flex flex-1 items-center justify-between gap-3 border-b border-white/[0.06] pb-4">
                                        <span class="text-sm {{ $enCurso ? 'font-bold text-white' : ($hecha ? 'text-slate-400' : 'text-slate-300') }}">
                                            {{ $texto }}
                                            @if ($enCurso)
                                                <span class="ml-2 rounded-full bg-[#39A900]/20 px-2 py-0.5 text-[10px] font-bold text-[#90EE90]">Ahora</span>
                                            @endif
                                        </span>
                                        <span class="whitespace-nowrap text-sm font-semibold tabular-nums {{ $enCurso ? 'text-[#65D62E]' : 'text-slate-400' }}">{{ Vista::fechaCorta($fecha) }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ol>

                        <div class="mt-7 grid gap-3 sm:grid-cols-2">
                            <a href="{{ route('publico.oferta', data_get($proxima, 'id')) }}"
                                class="flex items-center justify-center gap-2 rounded-xl border border-white/15 py-3.5 text-sm font-bold text-white transition hover:bg-white/10">
                                Ver detalles
                            </a>
                            <a href="{{ session('api_token') ? route('home') : route('registro') }}"
                                class="flex items-center justify-center gap-2 rounded-xl bg-white py-3.5 text-sm font-bold text-[#081B28] transition hover:bg-[#E8F7DF]">
                                Inscribirme <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    @else
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#90EE90]">Muy pronto</p>
                        <h2 class="mt-2 text-xl font-bold text-white">Nuevas convocatorias en camino</h2>
                        <p class="mt-3 text-sm leading-7 text-slate-300">
                            En este momento no hay ofertas publicadas. Crea tu cuenta como aspirante y entra
                            apenas abra la próxima convocatoria.
                        </p>
                        <a href="{{ route('registro') }}"
                            class="mt-7 flex w-full items-center justify-center gap-2 rounded-xl bg-white py-3.5 text-sm font-bold text-[#081B28] transition hover:bg-[#E8F7DF]">
                            Crear mi cuenta
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Curva de transición --}}
        <svg class="absolute inset-x-0 bottom-0 h-16 w-full text-white sm:h-24" viewBox="0 0 1440 96" preserveAspectRatio="none" aria-hidden="true">
            <path fill="currentColor" d="M0 96h1440V32c-180 40-420 64-720 64S180 72 0 32v64z" />
        </svg>
    </section>

    {{-- ============ CÓMO FUNCIONA ============ --}}
    <section id="como-funciona" class="mx-auto max-w-7xl scroll-mt-24 px-5 py-20 sm:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-sm font-bold text-[#39A900]">Cómo inscribirte</p>
            <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-[#081B28] sm:text-4xl">Cuatro pasos para estudiar en el SENA</h2>
            <p class="mt-4 text-slate-500">Todo el proceso se hace en línea. Solo necesitas tu documento y un correo.</p>
        </div>

        <div class="relative mt-14">
        <div class="absolute left-0 right-0 top-14 hidden h-px bg-gradient-to-r from-transparent via-[#39A900]/40 to-transparent lg:block" aria-hidden="true"></div>
        <ol class="relative grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['fa-user-plus', 'Crea tu cuenta', 'Regístrate como aspirante con tus datos y tu documento de identidad.'],
                ['fa-magnifying-glass', 'Elige una oferta', 'Revisa los programas abiertos, sus cupos y las fechas de la convocatoria.'],
                ['fa-pen-to-square', 'Presenta las pruebas', 'Asiste a las pruebas de selección en las fechas indicadas.'],
                ['fa-trophy', 'Consulta el resultado', 'Revisa si fuiste seleccionado y prepárate para iniciar tu formación.'],
            ] as [$icono, $titulo, $texto])
                <li class="relative rounded-2xl border border-gray-200 bg-white p-6 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <span class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#081B28] text-xl text-[#65D62E] shadow-lg">
                        <i class="fa-solid {{ $icono }}"></i>
                        <span class="absolute -right-2 -top-2 flex h-7 w-7 items-center justify-center rounded-full bg-[#39A900] text-xs font-extrabold text-white ring-4 ring-white">{{ $loop->iteration }}</span>
                    </span>
                    <h3 class="mt-5 font-bold text-[#081B28]">{{ $titulo }}</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">{{ $texto }}</p>
                </li>
            @endforeach
        </ol>
        </div>
    </section>

    {{-- ============ OFERTAS ============ --}}
    <section id="ofertas" class="scroll-mt-24 bg-[#F6F8F5]">
        <div class="mx-auto max-w-7xl px-5 py-20 sm:px-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <p class="text-sm font-bold text-[#39A900]">Convocatorias</p>
                    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-[#081B28] sm:text-4xl">Ofertas de formación abiertas</h2>
                </div>
                <p class="max-w-md text-slate-500">Cada oferta tiene su propio cronograma. Inscríbete antes de la fecha de cierre.</p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse (collect($ofertas)->take(6) as $oferta)
                    @include('Publico._tarjeta-oferta', ['oferta' => $oferta])
                @empty
                    <div class="rounded-3xl border-2 border-dashed border-gray-200 bg-white p-14 text-center sm:col-span-2 lg:col-span-3">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F7DF] text-2xl text-[#278000]">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-[#081B28]">No hay ofertas publicadas en este momento</h3>
                        <p class="mt-2 text-slate-500">Crea tu cuenta y te esperamos en la próxima convocatoria.</p>
                    </div>
                @endforelse
            </div>

            @if (count($ofertas))
                <div class="mt-12 text-center">
                    <a href="{{ route('publico.ofertas') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#081B28] px-7 py-4 text-sm font-bold text-white transition hover:bg-[#39A900]">
                        Ver todas las convocatorias <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- ============ PROGRAMAS ============ --}}
    <section id="programas" class="mx-auto max-w-7xl scroll-mt-24 px-5 py-20 sm:px-8">
        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
            <div>
                <p class="text-sm font-bold text-[#39A900]">Formación</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-[#081B28] sm:text-4xl">Programas de formación</h2>
                <p class="mt-3 max-w-xl text-slate-500">Programas técnicos y tecnólogos organizados por áreas de conocimiento.</p>
            </div>
            <div class="inline-flex rounded-xl border border-gray-200 bg-white p-1 shadow-sm" data-filtro-programas>
                @foreach (['' => 'Todos', 'Tecnico' => 'Técnicos', 'Tecnologo' => 'Tecnólogos'] as $valor => $texto)
                    <button type="button" data-nivel="{{ $valor }}"
                        class="rounded-lg px-4 py-2 text-sm font-semibold transition {{ $loop->first ? 'bg-[#081B28] text-white' : 'text-slate-500 hover:text-[#081B28]' }}">
                        {{ $texto }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse (collect($programas)->take(9) as $programa)
                @php $tecnologo = data_get($programa, 'nivel_programa') === 'Tecnologo'; @endphp
                <div data-programa="{{ data_get($programa, 'nivel_programa') }}"
                    class="group flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-5 transition hover:border-[#39A900]/40 hover:shadow-md">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl {{ $tecnologo ? 'bg-[#081B28] text-[#65D62E]' : 'bg-[#E8F7DF] text-[#278000]' }}">
                        <i class="fa-solid {{ $tecnologo ? 'fa-microchip' : 'fa-screwdriver-wrench' }}"></i>
                    </span>
                    <div class="min-w-0">
                        <span class="text-[11px] font-bold uppercase tracking-wide {{ $tecnologo ? 'text-[#081B28]' : 'text-[#278000]' }}">{{ $tecnologo ? 'Tecnólogo' : 'Técnico' }}</span>
                        <h3 class="mt-0.5 font-bold leading-snug text-[#081B28]">{{ data_get($programa, 'nombre') }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ data_get($programa, 'area.nombre', 'Área de formación') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-slate-500">Aún no hay programas registrados.</p>
            @endforelse
        </div>
    </section>

    {{-- ============ NOTICIAS ============ --}}
    @if (count($noticias))
        @php $principal = $noticias[0]; $resto = array_slice($noticias, 1); @endphp
        <section id="noticias" class="scroll-mt-24 bg-[#F6F8F5]">
            <div class="mx-auto max-w-7xl px-5 py-20 sm:px-8">
                <p class="text-sm font-bold text-[#39A900]">Actualidad</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-[#081B28] sm:text-4xl">Noticias de los centros</h2>

                <div class="mt-12 grid gap-6 lg:grid-cols-[1.4fr_1fr]">
                    <a href="{{ route('publico.noticia', data_get($principal, 'id')) }}" class="group block overflow-hidden rounded-3xl bg-[#081B28] shadow-xl">
                        <div class="relative h-72 overflow-hidden">
                            @if (Vista::archivo(data_get($principal, 'imagen')))
                                <img src="{{ Vista::archivo(data_get($principal, 'imagen')) }}" alt="" class="h-full w-full object-cover opacity-80 transition duration-500 group-hover:scale-105">
                            @else
                                <div class="h-full w-full bg-gradient-to-br from-[#123247] to-[#081B28]"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-[#081B28] via-[#081B28]/30 to-transparent"></div>
                            <span class="absolute left-6 top-6 rounded-full bg-[#39A900] px-3 py-1 text-xs font-bold text-white">{{ data_get($principal, 'categoria') }}</span>
                        </div>
                        <div class="p-7">
                            <p class="text-xs font-medium text-slate-400">{{ Vista::fechaCorta(data_get($principal, 'created_at')) }} · {{ data_get($principal, 'trainingcenter.nombre') }}</p>
                            <h3 class="mt-2 text-2xl font-bold leading-snug text-white">{{ data_get($principal, 'titulo') }}</h3>
                            <p class="mt-3 leading-7 text-slate-300">{{ \Illuminate\Support\Str::limit(data_get($principal, 'descripcion'), 220) }}</p>
                            <span class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-[#65D62E]">Leer noticia <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></span>
                        </div>
                    </a>

                    <div class="space-y-4">
                        @foreach ($resto as $noticia)
                            <a href="{{ route('publico.noticia', data_get($noticia, 'id')) }}" class="group flex gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                @if (Vista::archivo(data_get($noticia, 'imagen')))
                                    <img src="{{ Vista::archivo(data_get($noticia, 'imagen')) }}" alt="" class="h-24 w-28 shrink-0 rounded-xl object-cover">
                                @else
                                    <div class="flex h-24 w-28 shrink-0 items-center justify-center rounded-xl bg-[#E8F7DF] text-2xl text-[#278000]">
                                        <i class="fa-solid fa-newspaper"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-[#39A900]">{{ data_get($noticia, 'categoria') }}</p>
                                    <h3 class="mt-1 font-bold leading-snug text-[#081B28]">{{ data_get($noticia, 'titulo') }}</h3>
                                    <p class="mt-1 line-clamp-2 text-sm text-slate-500">{{ data_get($noticia, 'descripcion') }}</p>
                                </div>
                            </a>
                        @endforeach
                        <a href="{{ route('publico.noticias') }}"
                            class="flex items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-gray-300 p-4 text-sm font-bold text-[#081B28] transition hover:border-[#39A900] hover:text-[#278000]">
                            Ver todas las noticias <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ CENTROS ============ --}}
    <section id="centros" class="relative scroll-mt-24 overflow-hidden bg-[#081B28]">
        <div class="pointer-events-none absolute -right-24 top-0 h-80 w-80 rounded-full bg-[#39A900]/15 blur-[90px]"></div>
        <div class="relative mx-auto max-w-7xl px-5 py-20 sm:px-8">
            <p class="text-sm font-bold text-[#65D62E]">Dónde estamos</p>
            <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Centros de formación</h2>
            <p class="mt-3 max-w-xl text-slate-400">Las sedes donde se dictan los programas y se presentan las pruebas de selección.</p>

            <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($centros as $centro)
                    <div class="group rounded-2xl border border-white/[0.08] bg-white/[0.04] p-6 transition hover:border-[#39A900]/40 hover:bg-white/[0.07]">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#39A900]/15 text-[#65D62E] transition group-hover:bg-[#39A900] group-hover:text-white">
                            <i class="fa-solid fa-building-columns"></i>
                        </span>
                        <h3 class="mt-5 font-bold text-white">{{ data_get($centro, 'nombre') }}</h3>
                        <p class="mt-2 flex items-start gap-2 text-sm text-slate-400">
                            <i class="fa-solid fa-location-dot mt-1 text-xs text-[#39A900]"></i>
                            {{ data_get($centro, 'direccion') }}
                        </p>
                    </div>
                @empty
                    <p class="text-slate-400">Aún no hay centros registrados.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ============ LLAMADO FINAL ============ --}}
    <section class="mx-auto max-w-7xl px-5 py-20 sm:px-8">
        <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#39A900] to-[#247A16] px-8 py-14 shadow-2xl shadow-[#39A900]/20 sm:px-14">
            <div class="pointer-events-none absolute -right-16 -top-16 h-72 w-72 rounded-full border-[48px] border-white/10"></div>
            <div class="pointer-events-none absolute -bottom-24 left-1/3 h-56 w-56 rounded-full bg-white/10 blur-3xl"></div>
            <div class="relative flex flex-col items-start justify-between gap-8 lg:flex-row lg:items-center">
                <div class="max-w-xl">
                    <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">¿Listo para dar el siguiente paso?</h2>
                    <p class="mt-3 text-lg text-white/85">Crea tu cuenta como aspirante y recibe tu lugar en la próxima convocatoria.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('registro') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-7 py-4 text-sm font-bold text-[#278000] shadow-lg transition hover:-translate-y-0.5">
                        <i class="fa-solid fa-user-plus"></i> Crear cuenta
                    </a>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/30 px-7 py-4 text-sm font-bold text-white transition hover:bg-white/10">
                        Ya tengo cuenta
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Filtro de programas por nivel
        document.querySelectorAll('[data-filtro-programas] [data-nivel]').forEach(function(boton) {
            boton.addEventListener('click', function() {
                const nivel = this.dataset.nivel;
                document.querySelectorAll('[data-filtro-programas] [data-nivel]').forEach(function(b) {
                    const activo = b === boton;
                    b.classList.toggle('bg-[#081B28]', activo);
                    b.classList.toggle('text-white', activo);
                    b.classList.toggle('text-slate-500', !activo);
                });
                document.querySelectorAll('[data-programa]').forEach(function(tarjeta) {
                    tarjeta.style.display = !nivel || tarjeta.dataset.programa === nivel ? '' : 'none';
                });
            });
        });
    </script>
@endpush
