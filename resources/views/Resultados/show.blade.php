@extends('Layouts.Admin')

@section('title', 'Resultado de aprendizaje - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Resultado de aprendizaje',
        'volver' => ['url' => route('resultados.index'), 'texto' => 'Volver a resultados'],
        'boton' => ['url' => route('resultados.edit', data_get($resultado, 'id')), 'texto' => 'Editar', 'icono' => 'fa-pen'],
        'eliminar' => route('resultados.destroy', data_get($resultado, 'id')),
    ])

    <div class="space-y-6">
        <div class="tarjeta">
            @include('Includes.cabecera-detalle', [
                'icono' => 'fa-list-check',
                'subtitulo' => data_get($resultado, 'codigo') ? 'Código ' . data_get($resultado, 'codigo') : 'Resultado de aprendizaje',
                'titulo' => data_get($resultado, 'nombre'),
            ])
            <div class="grid gap-x-8 gap-y-6 p-6 sm:grid-cols-2 sm:p-8 lg:grid-cols-3">
                @include('Includes.dato', ['etiqueta' => 'Competencia', 'valor' => data_get($resultado, 'competition.nombre'), 'icono' => 'fa-book-open', 'ancho' => 'sm:col-span-2'])
                @include('Includes.dato', ['etiqueta' => 'Calificaciones', 'valor' => (string) data_get($resultado, 'grades_count', count(data_get($resultado, 'grades', []))), 'icono' => 'fa-clipboard-check'])
                @include('Includes.dato', ['etiqueta' => 'Descripción', 'valor' => data_get($resultado, 'descripcion'), 'icono' => 'fa-align-left', 'ancho' => 'sm:col-span-2 lg:col-span-3'])
            </div>
        </div>
        <section class="tarjeta overflow-hidden">
            <div class="flex items-center justify-between border-b border-linea px-5 py-4">
                <div class="flex items-baseline gap-2">
                    <h3 class="tarjeta-titulo">Calificaciones del resultado</h3>
                    <span class="rounded-md bg-papel px-1.5 py-0.5 text-xs font-medium text-slate-500">{{ count(data_get($resultado, 'grades', [])) }}</span>
                </div>
                <a href="{{ route('calificaciones.create') }}" class="btn-secundario min-h-9 px-3"><i class="fa-solid fa-plus text-xs"></i>Calificar</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[560px] text-sm">
                    <thead><tr><th class="th">Aprendiz</th><th class="th">Estado</th><th class="th">Calificó</th><th class="th">Comentarios</th></tr></thead>
                    <tbody class="divide-y divide-linea">
                        @forelse (data_get($resultado, 'grades', []) as $fila)
                        <tr class="fila">
                            <td class="td font-medium text-tinta">{{ Vista::nombre(data_get($fila, 'apprentice.user')) }}</td>
                            <td class="td">@include('Includes.estado', ['valor' => data_get($fila, 'estado_resultado')])</td>
                            <td class="td text-slate-600">{{ Vista::nombre(data_get($fila, 'teacher.user'), '—') }}</td>
                            <td class="td text-slate-500">{{ data_get($fila, 'comentarios') ?: '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-sm text-slate-500">Este resultado aún no tiene calificaciones.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
