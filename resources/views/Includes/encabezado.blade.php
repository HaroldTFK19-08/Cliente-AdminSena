{{--
    Encabezado de página (estilo original).
    Parámetros: titulo, (opc.) descripcion, boton => ['url','texto','icono'], volver => ['url','texto'], eliminar, confirmar
--}}
<div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        @isset($volver)
            <a href="{{ $volver['url'] }}" class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-[#39A900]">
                <i class="fa-solid fa-arrow-left"></i>
                {{ $volver['texto'] }}
            </a>
        @else
            <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                <i class="fa-solid fa-house"></i>
                <span>Administración</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="font-medium text-[#278000]">{{ $titulo }}</span>
            </div>
        @endisset

        <h1 class="text-2xl font-bold text-gray-900">{{ $titulo }}</h1>

        @isset($descripcion)
            <p class="mt-1 text-sm text-gray-500">{{ $descripcion }}</p>
        @endisset
    </div>

    @if (isset($boton) || isset($eliminar))
        <div class="flex shrink-0 gap-2">
            @isset($eliminar)
                <form action="{{ $eliminar }}" method="POST" onsubmit="return confirm('{{ $confirmar ?? '¿Seguro que deseas eliminar este registro?' }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-peligro"><i class="fa-solid fa-trash"></i>Eliminar</button>
                </form>
            @endisset
            @isset($boton)
                <a href="{{ $boton['url'] }}" class="btn-primario">
                    <i class="fa-solid {{ $boton['icono'] ?? 'fa-plus' }}"></i>
                    {{ $boton['texto'] }}
                </a>
            @endisset
        </div>
    @endif
</div>
