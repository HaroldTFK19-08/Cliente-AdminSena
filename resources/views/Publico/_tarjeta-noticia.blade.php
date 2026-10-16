{{-- Tarjeta de una noticia en el sitio público. Parámetro: noticia --}}
@php $imagen = Vista::archivo(data_get($noticia, 'imagen')); @endphp
<article data-noticia data-categoria="{{ data_get($noticia, 'categoria') }}"
    class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-[#081B28]/10">
    <a href="{{ route('publico.noticia', data_get($noticia, 'id')) }}" class="relative block h-48 overflow-hidden">
        @if ($imagen)
            <img src="{{ $imagen }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="relative flex h-full items-center justify-center overflow-hidden bg-gradient-to-br from-[#081B28] to-[#123247]">
                <div class="absolute -left-8 -bottom-8 h-32 w-32 rounded-full bg-[#39A900]/25 blur-2xl"></div>
                <i class="fa-solid fa-newspaper text-5xl text-[#39A900]/80"></i>
            </div>
        @endif
        <span class="absolute left-4 top-4 rounded-full bg-[#39A900] px-3 py-1 text-xs font-bold text-white shadow">{{ data_get($noticia, 'categoria') }}</span>
    </a>
    <div class="flex flex-1 flex-col p-6">
        <p class="text-xs font-medium text-slate-400">
            <i class="fa-regular fa-calendar mr-1"></i>{{ Vista::fechaCorta(data_get($noticia, 'created_at')) }}
        </p>
        <h3 class="mt-2 text-lg font-bold leading-snug text-[#081B28]">
            <a href="{{ route('publico.noticia', data_get($noticia, 'id')) }}" class="transition hover:text-[#278000]">{{ data_get($noticia, 'titulo') }}</a>
        </h3>
        <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-500">{{ data_get($noticia, 'descripcion') }}</p>
        <div class="mt-auto flex items-center justify-between pt-5 text-sm">
            <span class="flex items-center gap-2 truncate text-slate-500">
                <i class="fa-solid fa-building-columns text-xs text-[#39A900]"></i>
                <span class="truncate">{{ data_get($noticia, 'trainingcenter.nombre', 'SENA') }}</span>
            </span>
            <a href="{{ route('publico.noticia', data_get($noticia, 'id')) }}" class="shrink-0 font-bold text-[#278000]">
                Leer <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>
</article>
