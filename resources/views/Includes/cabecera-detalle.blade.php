{{-- Franja oscura de las vistas de detalle (estilo original). Parámetros: icono, subtitulo, titulo, (opc.) extra, imagen --}}
<div class="rounded-t-2xl bg-[#101D2D] px-6 py-8 sm:px-8">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
        @if (!empty($imagen))
            <img src="{{ $imagen }}" alt="" class="h-20 w-20 shrink-0 rounded-2xl object-cover ring-2 ring-white/10">
        @else
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-[#83DB55]">
                <i class="fa-solid {{ $icono }} text-3xl"></i>
            </div>
        @endif
        <div class="min-w-0">
            <p class="text-sm font-medium text-gray-300">{{ $subtitulo }}</p>
            <h2 class="mt-1 text-xl font-bold text-white sm:text-2xl">{{ $titulo }}</h2>
            @isset($extra)
                <div class="mt-2 text-sm text-gray-300">{!! $extra !!}</div>
            @endisset
        </div>
    </div>
</div>
