{{-- Fila para tablas sin registros (estilo original). Parámetros: columnas, icono, mensaje, (opc.) detalle, boton --}}
<tr>
    <td colspan="{{ $columnas }}" class="px-6 py-16 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
            <i class="fa-solid {{ $icono ?? 'fa-folder-open' }} text-2xl"></i>
        </div>
        <h3 class="mt-4 font-semibold text-gray-900">{{ $mensaje }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ $detalle ?? 'Registra el primero para comenzar.' }}</p>
        @isset($boton)
            <a href="{{ $boton['url'] }}" class="btn-primario mt-5 px-4 py-2.5">
                <i class="fa-solid fa-plus"></i>
                {{ $boton['texto'] }}
            </a>
        @endisset
    </td>
</tr>
