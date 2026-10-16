{{--
    Cabecera oscura de las páginas públicas (mismo estilo del login y registro).
    Parámetros: etiqueta, titulo, descripcion, (opc.) migas => [[texto, url], ...]
    Lo que se pase en la sección 'cabecera-extra' aparece debajo (filtros, cifras...).
--}}
<section class="relative overflow-hidden bg-[#081B28] pb-16 pt-32 lg:pt-36">
    @include('Publico._fondo')

    <div class="relative mx-auto max-w-7xl px-5 sm:px-8" data-aparece>
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-400" aria-label="Ruta">
            <a href="{{ route('publico.inicio') }}" class="transition hover:text-white"><i class="fa-solid fa-house"></i></a>
            @foreach ($migas ?? [] as [$texto, $url])
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-600"></i>
                @if ($url)
                    <a href="{{ $url }}" class="transition hover:text-white">{{ $texto }}</a>
                @else
                    <span class="text-slate-300">{{ $texto }}</span>
                @endif
            @endforeach
        </nav>

        <span class="mt-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3.5 py-1.5 text-xs font-semibold text-[#90EE90] backdrop-blur">
            <span class="h-2 w-2 rounded-full bg-[#39A900]"></span>
            {{ $etiqueta }}
        </span>
        <h1 class="mt-5 max-w-3xl text-4xl font-extrabold leading-[1.1] tracking-tight text-white sm:text-5xl">{{ $titulo }}</h1>
        <p class="mt-4 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">{{ $descripcion }}</p>

        @yield('cabecera-extra')
    </div>
</section>
