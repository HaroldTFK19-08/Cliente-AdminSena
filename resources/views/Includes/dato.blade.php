{{-- Tarjeta de un dato en las vistas de detalle (estilo original). Parámetros: etiqueta, valor, icono, (opc.) ancho --}}
<div class="rounded-xl border border-gray-100 bg-gray-50 p-5 {{ $ancho ?? '' }}">
    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#E8F7DF] text-[#278000]">
        <i class="fa-solid {{ $icono ?? 'fa-circle-info' }}"></i>
    </div>
    <p class="text-sm text-gray-500">{{ $etiqueta }}</p>
    <p class="mt-1 break-words font-semibold {{ filled($valor) ? 'text-gray-900' : 'text-gray-400' }}">{{ filled($valor) ? $valor : 'No disponible' }}</p>
</div>
