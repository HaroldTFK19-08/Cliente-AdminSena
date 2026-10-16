@extends('Layouts.Publico')

@section('title', 'Convocatorias abiertas - AdminSena')

@php
    $hoy = now()->toDateString();
    // Solo las ofertas publicadas; primero las abiertas y las que cierran antes
    $ofertas = collect($ofertas ?? [])
        ->filter(fn($o) => data_get($o, 'publicada'))
        ->sortBy(fn($o) => (substr((string) data_get($o, 'fecha_fin_convocatoria'), 0, 10) >= $hoy ? '0' : '1') . data_get($o, 'fecha_fin_convocatoria'))
        ->values();
    $abiertas = $ofertas->filter(fn($o) => substr((string) data_get($o, 'fecha_fin_convocatoria'), 0, 10) >= $hoy)->count();
@endphp

@section('cabecera-extra')
    {{-- Cifras + buscador en tarjeta de vidrio --}}
    <div class="mt-10 grid gap-4 lg:grid-cols-[auto_1fr]" data-aparece="2">
        <dl class="grid grid-cols-3 divide-x divide-white/10 rounded-2xl border border-white/10 bg-white/[0.05] backdrop-blur-xl">
            @foreach ([['Abiertas', $abiertas], ['Publicadas', $ofertas->count()], ['Cupos', $ofertas->sum('capacidad')]] as [$texto, $valor])
                <div class="px-6 py-4">
                    <dt class="text-xs text-slate-400">{{ $texto }}</dt>
                    <dd class="mt-1 text-2xl font-extrabold text-white tabular-nums">{{ number_format($valor, 0, ',', '.') }}</dd>
                </div>
            @endforeach
        </dl>

        <div class="flex flex-col gap-3 rounded-2xl border border-white/10 bg-white/[0.05] p-3 backdrop-blur-xl sm:flex-row sm:items-center">
            <label class="relative flex-1">
                <span class="sr-only">Buscar convocatoria</span>
                <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="search" id="buscarOferta" placeholder="Busca un programa o centro..."
                    class="w-full rounded-xl border border-white/10 bg-white/[0.06] py-3 pl-11 pr-4 text-sm text-white outline-none transition placeholder:text-slate-400 focus:border-[#39A900] focus:bg-white/10">
            </label>
            <div class="flex gap-1 rounded-xl bg-white/[0.06] p-1" id="filtroEstado">
                @foreach (['' => 'Todas', 'abierta' => 'Abiertas', 'cerrada' => 'Cerradas'] as $valor => $texto)
                    <button type="button" data-estado="{{ $valor }}"
                        class="rounded-lg px-4 py-2 text-sm font-semibold transition {{ $loop->first ? 'bg-[#39A900] text-white' : 'text-slate-300 hover:text-white' }}">
                        {{ $texto }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('contenido')
    @include('Publico._cabecera', [
        'etiqueta' => 'Convocatorias ' . now()->year,
        'titulo' => 'Ofertas de formación',
        'descripcion' => 'Programas técnicos y tecnólogos gratuitos. Revisa las fechas de cada convocatoria e inscríbete antes del cierre.',
        'migas' => [['Convocatorias', null]],
    ])

    <section class="bg-[#F6F8F5]">
        <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8">
            <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <p class="text-sm text-slate-500"><span id="contadorOfertas" class="font-bold text-[#081B28]">{{ $ofertas->count() }}</span> convocatorias</p>
                <div class="flex gap-2" id="filtroNivel">
                    @foreach (['' => 'Todos los niveles', 'Tecnico' => 'Técnico', 'Tecnologo' => 'Tecnólogo'] as $valor => $texto)
                        <button type="button" data-nivel="{{ $valor }}"
                            class="rounded-full border px-4 py-2 text-xs font-bold transition {{ $loop->first ? 'border-[#081B28] bg-[#081B28] text-white' : 'border-gray-300 bg-white text-slate-600 hover:border-[#081B28]' }}">
                            {{ $texto }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3" id="listaOfertas">
                @forelse ($ofertas as $oferta)
                    @include('Publico._tarjeta-oferta', ['oferta' => $oferta])
                @empty
                    <div class="rounded-3xl border-2 border-dashed border-gray-200 bg-white p-14 text-center sm:col-span-2 lg:col-span-3">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F7DF] text-2xl text-[#278000]">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-[#081B28]">No hay convocatorias publicadas</h3>
                        <p class="mt-2 text-slate-500">Crea tu cuenta y vuelve pronto para conocer las próximas ofertas.</p>
                    </div>
                @endforelse
            </div>

            <div id="sinOfertas" class="hidden rounded-3xl border-2 border-dashed border-gray-200 bg-white p-12 text-center">
                <i class="fa-solid fa-magnifying-glass text-3xl text-gray-300"></i>
                <p class="mt-4 font-bold text-[#081B28]">Ninguna convocatoria coincide con tu búsqueda</p>
                <p class="mt-1 text-sm text-slate-500">Prueba con otro programa o cambia los filtros.</p>
            </div>
        </div>
    </section>

    @include('Publico._llamado')
@endsection

@push('scripts')
    <script>
        // Buscador y filtros de convocatorias (sin recargar la página)
        (function() {
            const tarjetas = Array.from(document.querySelectorAll('[data-oferta]'));
            const filtros = { texto: '', estado: '', nivel: '' };

            function aplicar() {
                let visibles = 0;
                tarjetas.forEach(function(t) {
                    const ok = t.textContent.toLowerCase().includes(filtros.texto)
                        && (!filtros.estado || t.dataset.estado === filtros.estado)
                        && (!filtros.nivel || t.dataset.nivel === filtros.nivel);
                    t.style.display = ok ? '' : 'none';
                    if (ok) visibles++;
                });
                document.getElementById('contadorOfertas').textContent = visibles;
                document.getElementById('sinOfertas').classList.toggle('hidden', visibles > 0 || tarjetas.length === 0);
            }

            function grupo(id, clave, activas, inactivas) {
                document.querySelectorAll('#' + id + ' button').forEach(function(boton, _, todos) {
                    boton.addEventListener('click', function() {
                        filtros[clave] = this.dataset[clave];
                        todos.forEach(function(b) {
                            activas.forEach(c => b.classList.toggle(c, b === boton));
                            inactivas.forEach(c => b.classList.toggle(c, b !== boton));
                        });
                        aplicar();
                    });
                });
            }

            document.getElementById('buscarOferta').addEventListener('input', function() {
                filtros.texto = this.value.toLowerCase().trim();
                aplicar();
            });
            grupo('filtroEstado', 'estado', ['bg-[#39A900]', 'text-white'], ['text-slate-300']);
            grupo('filtroNivel', 'nivel', ['border-[#081B28]', 'bg-[#081B28]', 'text-white'], ['border-gray-300', 'bg-white', 'text-slate-600']);
        })();
    </script>
@endpush
