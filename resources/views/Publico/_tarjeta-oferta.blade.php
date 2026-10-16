{{-- Tarjeta de una oferta en el sitio público. Parámetro: oferta --}}
@php
    $imagen = Vista::archivo(data_get($oferta, 'imagen'));
    $cierre = data_get($oferta, 'fecha_fin_convocatoria');
    $abierta = $cierre && substr($cierre, 0, 10) >= now()->toDateString();
    $tecnologo = data_get($oferta, 'program.nivel_programa') === 'Tecnologo';
    $dias = $abierta ? (int) now()->startOfDay()->diffInDays(\Illuminate\Support\Carbon::parse($cierre), false) : null;
@endphp
<article data-oferta data-estado="{{ $abierta ? 'abierta' : 'cerrada' }}" data-nivel="{{ data_get($oferta, 'program.nivel_programa') }}"
    class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-[#081B28]/10">
    <a href="{{ route('publico.oferta', data_get($oferta, 'id')) }}" class="relative block h-44 overflow-hidden">
        @if ($imagen)
            <img src="{{ $imagen }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-[#081B28]/70 to-transparent"></div>
        @else
            <div class="relative flex h-full items-center justify-center overflow-hidden bg-gradient-to-br from-[#081B28] to-[#123247]">
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-[#39A900]/25 blur-2xl"></div>
                <i class="fa-solid fa-graduation-cap text-5xl text-[#39A900]/80"></i>
            </div>
        @endif
        <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1 text-xs font-bold text-[#081B28] shadow">
            {{ $tecnologo ? 'Tecnólogo' : 'Técnico' }}
        </span>
        <span class="absolute right-4 top-4 rounded-full px-3 py-1 text-xs font-bold shadow {{ $abierta ? 'bg-[#39A900] text-white' : 'bg-slate-700 text-slate-200' }}">
            @if ($abierta)
                {{ $dias === 0 ? 'Cierra hoy' : ($dias === 1 ? 'Cierra mañana' : 'Quedan ' . $dias . ' días') }}
            @else
                Cerrada
            @endif
        </span>
    </a>

    <div class="flex flex-1 flex-col p-6">
        <h3 class="text-lg font-bold leading-snug text-[#081B28]">
            <a href="{{ route('publico.oferta', data_get($oferta, 'id')) }}" class="transition hover:text-[#278000]">
                {{ data_get($oferta, 'program.nombre', 'Programa de formación') }}
            </a>
        </h3>
        <p class="mt-1.5 flex items-center gap-2 text-sm text-slate-500">
            <i class="fa-solid fa-location-dot text-xs text-[#39A900]"></i>
            {{ data_get($oferta, 'program.area.trainingcenter.nombre', 'Centro de formación SENA') }}
        </p>

        <div class="mt-5 grid grid-cols-2 gap-3">
            <div class="rounded-xl bg-[#F6F8F5] p-3">
                <p class="text-[11px] font-medium text-slate-500">Inscripciones hasta</p>
                <p class="mt-0.5 text-sm font-bold text-[#081B28]">{{ Vista::fechaCorta($cierre) }}</p>
            </div>
            <div class="rounded-xl bg-[#F6F8F5] p-3">
                <p class="text-[11px] font-medium text-slate-500">Cupos</p>
                <p class="mt-0.5 text-sm font-bold text-[#081B28]">{{ data_get($oferta, 'capacidad') }}</p>
            </div>
        </div>

        <div class="mt-auto pt-6">
            <a href="{{ route('publico.oferta', data_get($oferta, 'id')) }}"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#081B28] py-3 text-sm font-bold text-white transition group-hover:bg-[#39A900]">
                Ver convocatoria
                <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>
</article>
