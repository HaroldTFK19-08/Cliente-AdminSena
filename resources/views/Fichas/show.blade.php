@extends('Layouts.Admin')

@section('title', 'Ficha - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Ficha',
        'volver' => ['url' => route('fichas.index'), 'texto' => 'Volver a fichas'],
        'boton' => ['url' => route('fichas.edit', data_get($ficha, 'id')), 'texto' => 'Editar', 'icono' => 'fa-pen'],
        'eliminar' => route('fichas.destroy', data_get($ficha, 'id')),
    ])

    <div class="space-y-6">
        <div class="tarjeta">
            @include('Includes.cabecera-detalle', [
                'icono' => 'fa-users-rectangle',
                'subtitulo' => 'Ficha de formación',
                'titulo' => data_get($ficha, 'codigo', 'Sin código'),
            ])
            <div class="grid gap-x-8 gap-y-6 p-6 sm:grid-cols-2 sm:p-8 lg:grid-cols-3">
                @include('Includes.dato', ['etiqueta' => 'Programa', 'valor' => data_get($ficha, 'program.nombre'), 'icono' => 'fa-graduation-cap'])
                @include('Includes.dato', ['etiqueta' => 'Área', 'valor' => data_get($ficha, 'program.area.nombre'), 'icono' => 'fa-layer-group'])
                @include('Includes.dato', ['etiqueta' => 'Centro de formación', 'valor' => data_get($ficha, 'program.area.trainingcenter.nombre'), 'icono' => 'fa-building-columns'])
                @include('Includes.dato', ['etiqueta' => 'Instructor líder', 'valor' => Vista::nombre(data_get($ficha, 'teacher.user'), ''), 'icono' => 'fa-chalkboard-user'])
                @include('Includes.dato', ['etiqueta' => 'Ocupación', 'valor' => data_get($ficha, 'apprentices_count', count(data_get($ficha, 'apprentices', []))) . ' de ' . data_get($ficha, 'capacidad_aprendices', 0) . ' cupos', 'icono' => 'fa-user-graduate'])
                @include('Includes.dato', ['etiqueta' => 'Creada', 'valor' => Vista::fechaCorta(data_get($ficha, 'created_at')), 'icono' => 'fa-calendar-plus'])
            </div>
        </div>
        @php
            $ocupados = (int) data_get($ficha, 'apprentices_count', count(data_get($ficha, 'apprentices', [])));
            $cupos = max((int) data_get($ficha, 'capacidad_aprendices', 0), 1);
        @endphp
        <div class="tarjeta p-5">
            <div class="mb-2 flex justify-between text-sm">
                <span class="text-slate-500">Cupos ocupados</span>
                <span class="font-semibold text-azul-900 tabular-nums">{{ round($ocupados / $cupos * 100) }}%</span>
            </div>
            <div class="h-2 rounded-full bg-papel"><div class="h-2 rounded-full bg-sena-500" style="width: {{ min(100, round($ocupados / $cupos * 100)) }}%"></div></div>
        </div>
        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,2fr)]">
            <section class="tarjeta">
                <div class="flex items-baseline gap-2 border-b border-linea px-5 py-4">
                    <h3 class="tarjeta-titulo">Instructores</h3>
                    <span class="rounded-md bg-papel px-1.5 py-0.5 text-xs font-medium text-slate-500">{{ count(data_get($ficha, 'teachers', [])) }}</span>
                </div>
                <ul class="divide-y divide-linea">
                    @forelse (data_get($ficha, 'teachers', []) as $instructor)
                        <li class="flex items-center gap-3 px-5 py-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-azul-50 text-[11px] font-bold text-azul-800">{{ Vista::iniciales(data_get($instructor, 'user')) }}</span>
                            <span class="min-w-0">
                                <span class="block truncate text-sm font-medium text-tinta">{{ Vista::nombre(data_get($instructor, 'user')) }}</span>
                                <span class="block text-xs text-slate-500">{{ data_get($instructor, 'especialidad') }}</span>
                            </span>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-sm text-slate-500">Sin instructores asignados.</li>
                    @endforelse
                </ul>
            </section>
            <section class="tarjeta overflow-hidden">
            <div class="flex items-center justify-between border-b border-linea px-5 py-4">
                <div class="flex items-baseline gap-2">
                    <h3 class="tarjeta-titulo">Aprendices</h3>
                    <span class="rounded-md bg-papel px-1.5 py-0.5 text-xs font-medium text-slate-500">{{ count(data_get($ficha, 'apprentices', [])) }}</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[560px] text-sm">
                    <thead><tr><th class="th">Aprendiz</th><th class="th">Documento</th><th class="th">Estado</th></tr></thead>
                    <tbody class="divide-y divide-linea">
                        @forelse (data_get($ficha, 'apprentices', []) as $fila)
                        <tr class="fila">
                            <td class="td font-medium text-tinta">{{ Vista::nombre(data_get($fila, 'user')) }}</td>
                            <td class="td text-slate-600">{{ data_get($fila, 'user.identificacion') }}</td>
                            <td class="td">@include('Includes.estado', ['valor' => data_get($fila, 'estado')])</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-5 py-10 text-center text-sm text-slate-500">La ficha aún no tiene aprendices.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        </div>
    </div>
@endsection
