@extends('Layouts.Publico')

@section('title', data_get($noticia, 'titulo', 'Noticia') . ' - AdminSena')
@section('barra-solida', '1')

@section('contenido')
    @php
        $imagen = Vista::archivo(data_get($noticia, 'imagen'));
        $categorias = ['Tecnologia' => 'Tecnología', 'Educacion' => 'Educación', 'Deporte' => 'Deporte', 'Politica' => 'Política', 'Artistica' => 'Artística', 'Diseño' => 'Diseño'];
        $texto = (string) data_get($noticia, 'descripcion', '');
        $minutos = max(1, (int) ceil(str_word_count($texto) / 200));

        // Más noticias publicadas: primero las de la misma categoría
        $relacionadas = collect($noticias ?? [])
            ->filter(fn($n) => (data_get($n, 'publicada') || data_get($n, 'estado') === 'Publicado') && data_get($n, 'id') != data_get($noticia, 'id'))
            ->sortByDesc(fn($n) => (data_get($n, 'categoria') === data_get($noticia, 'categoria') ? '1' : '0') . data_get($n, 'created_at'))
            ->take(3)->values();
    @endphp

    <div class="grid lg:min-h-screen lg:grid-cols-[1fr_1.15fr]">
        {{-- ======== Panel oscuro (igual al login) ======== --}}
        <aside class="relative overflow-hidden bg-[#081B28] px-5 pb-12 pt-28 sm:px-10 lg:sticky lg:top-0 lg:flex lg:h-screen lg:flex-col lg:px-14 lg:pt-32">
            @include('Publico._fondo')

            <div class="relative" data-aparece>
                <a href="{{ route('publico.noticias') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 transition hover:text-white">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Todas las noticias
                </a>

                <span class="mt-6 inline-flex rounded-full bg-[#39A900] px-3 py-1 text-xs font-bold text-white">
                    {{ $categorias[data_get($noticia, 'categoria')] ?? data_get($noticia, 'categoria') }}
                </span>
                <h1 class="mt-5 text-3xl font-extrabold leading-tight tracking-tight text-white sm:text-4xl">{{ data_get($noticia, 'titulo') }}</h1>

                <div class="mt-8 space-y-4 rounded-2xl border border-white/10 bg-white/[0.05] p-5 backdrop-blur-xl">
                    @foreach ([
                        ['fa-building-columns', 'Publicada por', data_get($noticia, 'trainingcenter.nombre', 'SENA')],
                        ['fa-regular fa-calendar', 'Fecha', Vista::fechaCorta(data_get($noticia, 'created_at'))],
                        ['fa-regular fa-clock', 'Lectura', $minutos . ' min'],
                    ] as [$icono, $etiqueta, $valor])
                        <div class="flex items-center gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#39A900]/15 text-[#65D62E]">
                                <i class="{{ str_contains($icono, 'fa-regular') ? $icono : 'fa-solid ' . $icono }}"></i>
                            </span>
                            <span>
                                <span class="block text-xs text-slate-400">{{ $etiqueta }}</span>
                                <span class="block text-sm font-bold text-white">{{ $valor }}</span>
                            </span>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="copiarEnlace"
                    class="mt-6 inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/5 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i class="fa-solid fa-link text-xs"></i> <span>Copiar enlace</span>
                </button>
            </div>
        </aside>

        {{-- ======== Artículo ======== --}}
        <main class="bg-[#F6F8F5] px-5 py-12 sm:px-10 lg:px-14 lg:pt-32">
            <div class="mx-auto max-w-2xl space-y-6" data-aparece="2">
                <article class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                    @if ($imagen)
                        <img src="{{ $imagen }}" alt="" class="aspect-[16/9] w-full object-cover">
                    @endif
                    <div class="p-7 sm:p-10">
                        <div class="whitespace-pre-line text-[17px] leading-8 text-slate-700 first-letter:float-left first-letter:mr-3 first-letter:text-6xl first-letter:font-extrabold first-letter:leading-[0.9] first-letter:text-[#39A900]">{{ $texto }}</div>
                    </div>
                </article>

                @if ($relacionadas->count())
                    <div class="rounded-3xl border border-gray-200 bg-white p-7 shadow-sm sm:p-9">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-extrabold text-[#081B28]">Sigue leyendo</h2>
                            <a href="{{ route('publico.noticias') }}" class="text-sm font-bold text-[#278000] hover:underline">Ver todas</a>
                        </div>
                        <ul class="mt-5 divide-y divide-gray-100">
                            @foreach ($relacionadas as $otra)
                                <li>
                                    <a href="{{ route('publico.noticia', data_get($otra, 'id')) }}" class="group flex items-center gap-4 py-4">
                                        @if (Vista::archivo(data_get($otra, 'imagen')))
                                            <img src="{{ Vista::archivo(data_get($otra, 'imagen')) }}" alt="" class="h-16 w-20 shrink-0 rounded-xl object-cover">
                                        @else
                                            <span class="flex h-16 w-20 shrink-0 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]"><i class="fa-solid fa-newspaper"></i></span>
                                        @endif
                                        <span class="min-w-0 flex-1">
                                            <span class="block text-xs font-bold text-[#39A900]">{{ $categorias[data_get($otra, 'categoria')] ?? data_get($otra, 'categoria') }}</span>
                                            <span class="block font-bold leading-snug text-[#081B28] transition group-hover:text-[#278000]">{{ data_get($otra, 'titulo') }}</span>
                                        </span>
                                        <i class="fa-solid fa-chevron-right text-xs text-slate-300 transition group-hover:translate-x-1 group-hover:text-[#39A900]"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('copiarEnlace').addEventListener('click', function() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                this.querySelector('span').textContent = 'Enlace copiado';
                setTimeout(() => this.querySelector('span').textContent = 'Copiar enlace', 2000);
            });
        });
    </script>
@endpush
