{{-- Botones ver / editar / eliminar. Parámetros: ver, editar, eliminar, confirmar --}}
<div class="flex items-center justify-end gap-1">
    @if (!empty($ver))
        <a href="{{ $ver }}" title="Ver detalles" aria-label="Ver detalles"
            class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-azul-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sena-500/40">
            <i class="fa-solid fa-eye"></i>
        </a>
    @endif
    @if (!empty($editar))
        <a href="{{ $editar }}" title="Editar" aria-label="Editar"
            class="flex h-9 w-9 items-center justify-center rounded-lg text-sena-700 transition hover:bg-sena-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sena-500/40">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
    @endif
    @if (!empty($eliminar))
        <form action="{{ $eliminar }}" method="POST" data-confirmar="{{ $confirmar ?? '¿Seguro que deseas eliminar este registro?' }}">
            @csrf
            @method('DELETE')
            <button type="submit" title="Eliminar" aria-label="Eliminar"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500/40">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    @endif
</div>
