{{--
    Encabezado de página.
    Parámetros: titulo, (opc.) descripcion, boton => ['url','texto','icono'], volver => ['url','texto'], eliminar, confirmar
--}}
@php
    $esAdminEnc = data_get(session('usuario'), 'rol') === 'Admin';
    $raiz = $esAdminEnc ? 'Administración' : (session('api_token') ? 'Mi cuenta' : 'Comunidad SENA');
@endphp
<div class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div class="min-w-0">
        @isset($volver)
            <a href="{{ $volver['url'] }}"
                class="group mb-3 inline-flex items-center gap-2 rounded-lg text-sm font-medium text-slate-500 transition hover:text-sena-700">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white transition group-hover:border-sena-200 group-hover:bg-sena-50">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </span>
                {{ $volver['texto'] }}
            </a>
        @else
            <nav aria-label="Ruta" class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <i class="fa-solid fa-house text-[11px]"></i>
                <span>{{ $raiz }}</span>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <span class="text-sena-700">{{ $titulo }}</span>
            </nav>
        @endisset

        <h1 class="text-2xl font-extrabold tracking-tight text-azul-900 sm:text-[1.75rem]">{{ $titulo }}</h1>

        @isset($descripcion)
            <p class="mt-1.5 max-w-2xl text-sm leading-6 text-slate-500">{{ $descripcion }}</p>
        @endisset
    </div>

    @if (isset($boton) || isset($eliminar))
        <div class="flex shrink-0 flex-wrap gap-2">
            @isset($eliminar)
                <form action="{{ $eliminar }}" method="POST" data-confirmar="{{ $confirmar ?? '¿Seguro que deseas eliminar este registro?' }}">
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
