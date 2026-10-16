@extends('Layouts.Publico')

@section('title', 'Noticias - AdminSena')

@php
    // Solo noticias publicadas, de la más reciente a la más antigua
    $noticias = collect($noticias ?? [])
        ->filter(fn($n) => data_get($n, 'publicada') || data_get($n, 'estado') === 'Publicado')
        ->sortByDesc('created_at')->values();
    $destacada = $noticias->first();
    $resto = $noticias->slice(1)->values();
    $categorias = ['Tecnologia' => 'Tecnología', 'Educacion' => 'Educación', 'Deporte' => 'Deporte', 'Politica' => 'Política', 'Artistica' => 'Artística', 'Diseño' => 'Diseño'];
@endphp

@section('cabecera-extra')
    {{-- Categorías en tarjeta de vidrio --}}
    <div class="mt-10 flex flex-wrap gap-2 rounded-2xl border border-white/10 bg-white/[0.05] p-2 backdrop-blur-xl sm:inline-flex" id="filtroCategoria" data-aparece="2">
        <button type="button" data-categoria="" class="rounded-xl bg-[#39A900] px-4 py-2 text-sm font-semibold text-white transition">
            Todas <span class="ml-1 opacity-70">{{ $noticias->count() }}</span>
        </button>
        @foreach ($categorias as $valor => $texto)
            @php $cantidad = $noticias->where('categoria', $valor)->count(); @endphp
            @if ($cantidad)
                <button type="button" data-categoria="{{ $valor }}" class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-300 transition hover:text-white">
                    {{ $texto }} <span class="ml-1 opacity-60">{{ $cantidad }}</span>
                </button>
            @endif
        @endforeach
    </div>
@endsection

@section('contenido')
    @include('Publico._cabecera', [
        'etiqueta' => 'Actualidad SENA',
        'titulo' => 'Noticias de los centros de formación',
        'descripcion' => 'Novedades, eventos y logros de los aprendices, instructores y centros del SENA.',
        'migas' => [['Noticias', null]],
    ])

    <section class="bg-[#F6F8F5]">
        <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8">
            @if ($destacada)
                {{-- Noticia destacada --}}
                <a href="{{ route('publico.noticia', data_get($destacada, 'id')) }}" data-noticia data-categoria="{{ data_get($destacada, 'categoria') }}"
                    class="group mb-10 grid overflow-hidden rounded-3xl bg-[#081B28] shadow-xl lg:grid-cols-[1.3fr_1fr]">
                    <div class="relative min-h-72 overflow-hidden">
                        @if (Vista::archivo(data_get($destacada, 'imagen')))
                            <img src="{{ Vista::archivo(data_get($destacada, 'imagen')) }}" alt="" class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-[#123247] to-[#081B28]"></div>
                            <i class="fa-solid fa-newspaper absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-7xl text-[#39A900]/60"></i>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent to-[#081B28]/60 lg:to-[#081B28]"></div>
                        <span class="absolute left-6 top-6 rounded-full bg-[#39A900] px-3 py-1 text-xs font-bold text-white">Destacada</span>
                    </div>
                    <div class="relative flex flex-col justify-center p-8 sm:p-10">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#90EE90]">{{ $categorias[data_get($destacada, 'categoria')] ?? data_get($destacada, 'categoria') }}</p>
                        <h2 class="mt-3 text-2xl font-extrabold leading-snug text-white sm:text-3xl">{{ data_get($destacada, 'titulo') }}</h2>
                        <p class="mt-4 line-clamp-3 leading-7 text-slate-300">{{ data_get($destacada, 'descripcion') }}</p>
                        <p class="mt-6 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-400">
                            <span><i class="fa-regular fa-calendar mr-1.5"></i>{{ Vista::fechaCorta(data_get($destacada, 'created_at')) }}</span>
                            <span><i class="fa-solid fa-building-columns mr-1.5"></i>{{ data_get($destacada, 'trainingcenter.nombre', 'SENA') }}</span>
                        </p>
                        <span class="mt-7 inline-flex items-center gap-2 font-bold text-[#65D62E]">
                            Leer la noticia <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
                        </span>
                    </div>
                </a>
            @endif

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($resto as $noticia)
                    @include('Publico._tarjeta-noticia', ['noticia' => $noticia])
                @endforeach
            </div>

            @if (!$destacada)
                <div class="rounded-3xl border-2 border-dashed border-gray-200 bg-white p-14 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F7DF] text-2xl text-[#278000]">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-[#081B28]">Aún no hay noticias publicadas</h3>
                    <p class="mt-2 text-slate-500">Pronto encontrarás aquí las novedades de los centros.</p>
                </div>
            @endif

            <div id="sinNoticias" class="hidden rounded-3xl border-2 border-dashed border-gray-200 bg-white p-12 text-center">
                <p class="font-bold text-[#081B28]">No hay noticias en esta categoría</p>
                <p class="mt-1 text-sm text-slate-500">Elige otra categoría para ver más.</p>
            </div>
        </div>
    </section>

    @include('Publico._llamado')
@endsection

@push('scripts')
    <script>
        // Filtro de noticias por categoría
        (function() {
            const noticias = Array.from(document.querySelectorAll('[data-noticia]'));
            document.querySelectorAll('#filtroCategoria button').forEach(function(boton, _, todos) {
                boton.addEventListener('click', function() {
                    const categoria = this.dataset.categoria;
                    todos.forEach(function(b) {
                        b.classList.toggle('bg-[#39A900]', b === boton);
                        b.classList.toggle('text-white', b === boton);
                        b.classList.toggle('text-slate-300', b !== boton);
                    });
                    let visibles = 0;
                    noticias.forEach(function(n) {
                        const ok = !categoria || n.dataset.categoria === categoria;
                        n.style.display = ok ? '' : 'none';
                        if (ok) visibles++;
                    });
                    document.getElementById('sinNoticias').classList.toggle('hidden', visibles > 0);
                });
            });
        })();
    </script>
@endpush
