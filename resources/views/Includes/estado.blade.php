{{-- Etiqueta de estado con punto de color. Parámetro: valor --}}
@if (filled($valor ?? null))
    <span class="insignia {{ Vista::colorEstado($valor) }}">
        <span class="h-1.5 w-1.5 rounded-full {{ Vista::puntoEstado($valor) }}"></span>
        {{ $valor }}
    </span>
@else
    <span class="text-slate-400">—</span>
@endif
