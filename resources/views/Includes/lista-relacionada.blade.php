{{-- Lista de registros relacionados en un detalle. Parámetros: titulo, icono, items, campo, (opc.) ruta, vacio --}}
<section class="tarjeta">
    <div class="flex items-center justify-between border-b border-linea px-5 py-4">
        <h3 class="tarjeta-titulo">{{ $titulo }}</h3>
        <span class="rounded-md bg-papel px-1.5 py-0.5 text-xs font-medium text-slate-500">{{ count($items) }}</span>
    </div>
    <ul class="divide-y divide-linea">
        @forelse ($items as $item)
            <li>
                @if (!empty($ruta))
                    <a href="{{ route($ruta, data_get($item, 'id')) }}" class="flex items-center gap-3 px-5 py-3 text-sm transition hover:bg-papel">
                        <i class="fa-solid {{ $icono }} w-4 text-center text-xs text-slate-400"></i>
                        <span class="flex-1 font-medium text-tinta">{{ data_get($item, $campo) }}</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                    </a>
                @else
                    <div class="flex items-center gap-3 px-5 py-3 text-sm">
                        <i class="fa-solid {{ $icono }} w-4 text-center text-xs text-slate-400"></i>
                        <span class="font-medium text-tinta">{{ data_get($item, $campo) }}</span>
                    </div>
                @endif
            </li>
        @empty
            <li class="px-5 py-8 text-center text-sm text-slate-500">{{ $vacio ?? 'Nada registrado todavía.' }}</li>
        @endforelse
    </ul>
</section>
