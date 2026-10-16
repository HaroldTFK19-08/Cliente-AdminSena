{{-- Botones ver / editar / eliminar (estilo original). Parámetros: ver, editar, eliminar, confirmar --}}
<div class="flex items-center justify-end gap-2">
    @if (!empty($ver))
        <a href="{{ $ver }}" title="Ver detalles" aria-label="Ver detalles"
            class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-900">
            <i class="fa-solid fa-eye"></i>
        </a>
    @endif
    @if (!empty($editar))
        <a href="{{ $editar }}" title="Editar" aria-label="Editar"
            class="flex h-9 w-9 items-center justify-center rounded-lg text-[#278000] transition hover:bg-[#E8F7DF]">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
    @endif
    @if (!empty($eliminar))
        <form action="{{ $eliminar }}" method="POST" onsubmit="return confirm('{{ $confirmar ?? '¿Seguro que deseas eliminar este registro?' }}')">
            @csrf
            @method('DELETE')
            <button type="submit" title="Eliminar" aria-label="Eliminar"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-50">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    @endif
</div>
