@extends('Layouts.Publico')

@section('title', data_get($oferta, 'program.nombre', 'Convocatoria') . ' - AdminSena')

@section('barra-solida', '1')

@section('contenido')
    @php
        $hoy = now()->toDateString();
        $imagen = Vista::archivo(data_get($oferta, 'imagen'));
        $cierre = data_get($oferta, 'fecha_fin_convocatoria');
        $abierta = $cierre && substr($cierre, 0, 10) >= $hoy;
        $dias = $abierta ? (int) now()->startOfDay()->diffInDays(\Illuminate\Support\Carbon::parse($cierre), false) : null;
        $tecnologo = data_get($oferta, 'program.nivel_programa') === 'Tecnologo';

        $etapas = array_values(array_filter([
            ['Lanzamiento', data_get($oferta, 'fecha_lanzamiento'), 'fa-rocket'],
            ['Abre la convocatoria', data_get($oferta, 'fecha_convocatoria'), 'fa-door-open'],
            ['Cierran las inscripciones', $cierre, 'fa-lock'],
            ['Primera prueba', data_get($oferta, 'fecha_primera_prueba'), 'fa-pen'],
            ['Segunda prueba', data_get($oferta, 'fecha_segunda_prueba'), 'fa-pen-to-square'],
            ['Publicación de seleccionados', data_get($oferta, 'fecha_seleccionados'), 'fa-trophy'],
        ], fn($e) => filled($e[1])));
        $actual = collect($etapas)->search(fn($e) => substr($e[1], 0, 10) >= $hoy);
        $actual = $actual === false ? count($etapas) : $actual;

        // Otras convocatorias publicadas y abiertas
        $otras = collect($ofertas ?? [])
            ->filter(fn($o) => data_get($o, 'publicada') && data_get($o, 'id') != data_get($oferta, 'id') && substr((string) data_get($o, 'fecha_fin_convocatoria'), 0, 10) >= $hoy)
            ->take(3)->values();
    @endphp

    <div class="grid lg:min-h-screen lg:grid-cols-[1fr_1.15fr]">
        {{-- ======== Panel oscuro (igual al login) ======== --}}
        <aside class="relative overflow-hidden bg-[#081B28] px-5 pb-12 pt-28 sm:px-10 lg:sticky lg:top-0 lg:h-screen lg:overflow-y-auto lg:px-14 lg:pt-32">
            @include('Publico._fondo')

            <div class="relative" data-aparece>
                <a href="{{ route('publico.ofertas') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 transition hover:text-white">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Todas las convocatorias
                </a>

                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-bold text-white">{{ $tecnologo ? 'Tecnólogo' : 'Técnico' }}</span>
                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $abierta ? 'bg-[#39A900] text-white' : 'bg-slate-700 text-slate-200' }}">
                        {{ $abierta ? 'Inscripciones abiertas' : 'Convocatoria cerrada' }}
                    </span>
                </div>

                <h1 class="mt-5 text-3xl font-extrabold leading-tight tracking-tight text-white sm:text-4xl">
                    {{ data_get($oferta, 'program.nombre', 'Programa de formación') }}
                </h1>
                <p class="mt-3 flex items-center gap-2 text-slate-300">
                    <i class="fa-solid fa-location-dot text-[#39A900]"></i>
                    {{ data_get($oferta, 'program.area.trainingcenter.nombre', 'Centro de formación SENA') }}
                </p>

                {{-- Cifras en vidrio --}}
                <dl class="mt-8 grid grid-cols-3 divide-x divide-white/10 rounded-2xl border border-white/10 bg-white/[0.05] backdrop-blur-xl">
                    <div class="p-4">
                        <dt class="text-[11px] text-slate-400">Cupos</dt>
                        <dd class="mt-1 text-2xl font-extrabold text-white tabular-nums">{{ data_get($oferta, 'capacidad', '—') }}</dd>
                    </div>
                    <div class="p-4">
                        <dt class="text-[11px] text-slate-400">Cierra</dt>
                        <dd class="mt-1 text-sm font-bold text-white">{{ Vista::fechaCorta($cierre) }}</dd>
                    </div>
                    <div class="p-4">
                        <dt class="text-[11px] text-slate-400">{{ $abierta ? 'Faltan' : 'Estado' }}</dt>
                        <dd class="mt-1 text-2xl font-extrabold tabular-nums {{ $abierta ? 'text-[#65D62E]' : 'text-slate-400' }}">
                            {{ $abierta ? $dias . ' d' : '—' }}
                        </dd>
                    </div>
                </dl>

                {{-- Cronograma --}}
                <div class="mt-8 rounded-2xl border border-white/10 bg-white/[0.04] p-6 backdrop-blur-xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#90EE90]">Cronograma</p>
                    <ol class="mt-5">
                        @foreach ($etapas as $i => [$texto, $fecha, $icono])
                            @php $hecha = $i < $actual; $enCurso = $i === $actual; @endphp
                            <li class="relative flex gap-4 pb-4 last:pb-0">
                                @unless ($loop->last)
                                    <span class="absolute left-[15px] top-8 h-[calc(100%-1.5rem)] w-0.5 {{ $hecha ? 'bg-[#39A900]' : 'bg-white/10' }}"></span>
                                @endunless
                                <span class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-[11px]
                                    {{ $hecha ? 'bg-[#39A900] text-white' : ($enCurso ? 'bg-white text-[#278000] ring-4 ring-[#39A900]/30' : 'bg-white/[0.06] text-slate-400') }}">
                                    <i class="fa-solid {{ $hecha ? 'fa-check' : $icono }}"></i>
                                </span>
                                <div class="flex flex-1 items-center justify-between gap-3">
                                    <span class="text-sm {{ $enCurso ? 'font-bold text-white' : ($hecha ? 'text-slate-500' : 'text-slate-300') }}">{{ $texto }}</span>
                                    <span class="whitespace-nowrap text-xs font-semibold tabular-nums {{ $enCurso ? 'text-[#65D62E]' : 'text-slate-500' }}">{{ Vista::fechaCorta($fecha) }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>

                {{-- Acción --}}
                @if ($abierta)
                    <a href="{{ session('api_token') ? route('home') : route('registro') }}"
                        class="group mt-8 flex w-full items-center justify-center gap-2 rounded-xl bg-[#39A900] py-4 text-sm font-bold text-white shadow-lg shadow-[#39A900]/25 transition hover:-translate-y-0.5 hover:bg-[#2e8800]">
                        {{ session('api_token') ? 'Continuar en mi panel' : 'Crear cuenta e inscribirme' }}
                        <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
                    </a>
                    @unless (session('api_token'))
                        <p class="mt-3 text-center text-xs text-slate-400">
                            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="font-semibold text-[#65D62E] hover:underline">Inicia sesión</a>
                        </p>
                    @endunless
                @else
                    <p class="mt-8 rounded-xl border border-white/10 bg-white/[0.04] p-4 text-center text-sm text-slate-300">
                        Esta convocatoria ya cerró. Revisa las demás ofertas abiertas.
                    </p>
                @endif
            </div>
        </aside>

        {{-- ======== Contenido ======== --}}
        <main class="bg-[#F6F8F5] px-5 py-12 sm:px-10 lg:px-14 lg:pt-32">
            <div class="mx-auto max-w-2xl space-y-6" data-aparece="2">
                <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                    @if ($imagen)
                        <img src="{{ $imagen }}" alt="" class="aspect-[16/9] w-full object-cover">
                    @else
                        <div class="relative flex aspect-[16/9] items-center justify-center overflow-hidden bg-gradient-to-br from-[#081B28] to-[#123247]">
                            <div class="absolute -right-10 -top-10 h-48 w-48 rounded-full bg-[#39A900]/25 blur-3xl"></div>
                            <i class="fa-solid fa-graduation-cap text-7xl text-[#39A900]/80"></i>
                        </div>
                    @endif
                    <div class="p-7 sm:p-9">
                        <h2 class="text-xl font-extrabold text-[#081B28]">Sobre el programa</h2>
                        <p class="mt-3 leading-8 text-slate-600">
                            {{ data_get($oferta, 'program.nombre', 'Este programa') }} es un programa de nivel
                            {{ $tecnologo ? 'tecnólogo' : 'técnico' }} del área de {{ data_get($oferta, 'program.area.nombre', 'formación') }},
                            ofrecido por {{ data_get($oferta, 'program.area.trainingcenter.nombre', 'el SENA') }}.
                            La convocatoria tiene {{ data_get($oferta, 'capacidad', 'varios') }} cupos disponibles.
                        </p>

                        <dl class="mt-7 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['fa-signal', 'Nivel', $tecnologo ? 'Tecnólogo' : 'Técnico'],
                                ['fa-hashtag', 'Código del programa', data_get($oferta, 'program.codigo_programa', '—')],
                                ['fa-layer-group', 'Área', data_get($oferta, 'program.area.nombre', '—')],
                                ['fa-building-columns', 'Centro', data_get($oferta, 'program.area.trainingcenter.nombre', '—')],
                            ] as [$icono, $texto, $valor])
                                <div class="flex items-center gap-4 rounded-2xl bg-[#F6F8F5] p-4">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]">
                                        <i class="fa-solid {{ $icono }}"></i>
                                    </span>
                                    <span class="min-w-0">
                                        <dt class="text-xs text-slate-500">{{ $texto }}</dt>
                                        <dd class="truncate font-bold text-[#081B28]">{{ $valor }}</dd>
                                    </span>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>

                {{-- Qué necesitas --}}
                <div class="rounded-3xl border border-gray-200 bg-white p-7 shadow-sm sm:p-9">
                    <h2 class="text-xl font-extrabold text-[#081B28]">Qué necesitas para inscribirte</h2>
                    <ul class="mt-5 space-y-4">
                        @foreach ([
                            ['fa-id-card', 'Documento de identidad', 'Cédula, tarjeta de identidad, cédula de extranjería o PPT.'],
                            ['fa-envelope', 'Un correo electrónico', 'Allí recibirás la información de tu proceso.'],
                            ['fa-file-lines', 'Tus certificados', 'Certificado de EPS, diploma de bachiller y resultado ICFES.'],
                        ] as [$icono, $titulo, $texto])
                            <li class="flex gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#081B28] text-[#65D62E]">
                                    <i class="fa-solid {{ $icono }} text-sm"></i>
                                </span>
                                <span>
                                    <span class="block font-bold text-[#081B28]">{{ $titulo }}</span>
                                    <span class="block text-sm text-slate-500">{{ $texto }}</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Otras convocatorias --}}
                @if ($otras->count())
                    <div class="rounded-3xl border border-gray-200 bg-white p-7 shadow-sm sm:p-9">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-extrabold text-[#081B28]">Otras convocatorias abiertas</h2>
                            <a href="{{ route('publico.ofertas') }}" class="text-sm font-bold text-[#278000] hover:underline">Ver todas</a>
                        </div>
                        <ul class="mt-5 divide-y divide-gray-100">
                            @foreach ($otras as $otra)
                                <li>
                                    <a href="{{ route('publico.oferta', data_get($otra, 'id')) }}" class="group flex items-center gap-4 py-4">
                                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000] transition group-hover:bg-[#39A900] group-hover:text-white">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                        </span>
                                        <span class="min-w-0 flex-1">
                                            <span class="block truncate font-bold text-[#081B28]">{{ data_get($otra, 'program.nombre') }}</span>
                                            <span class="block text-xs text-slate-500">Cierra el {{ Vista::fechaCorta(data_get($otra, 'fecha_fin_convocatoria')) }}</span>
                                        </span>
                                        <i class="fa-solid fa-chevron-right text-xs text-slate-300 transition group-hover:translate-x-1 group-hover:text-[#39A900]"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
