@extends('Layouts.Admin')

@section('title', 'Resultados de aprendizaje - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Resultados de aprendizaje',
        'descripcion' => 'Resultados que componen cada competencia y que se califican a los aprendices.',
        'boton' => ['url' => route('resultados.create'), 'texto' => 'Nuevo resultado'],
    ])

    <div class="tarjeta overflow-hidden">
        @include('Includes.barra-busqueda', [
            'titulo' => 'Resultados registrados',
            'placeholder' => 'Buscar por código, nombre o competencia',
            'total' => count($resultados ?? []),
        ])

        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-sm">
                <thead>
                    <tr>
                            <th class="th">Resultado</th>
                            <th class="th">Competencia</th>
                            <th class="th">Descripción</th>
                            <th class="th w-px text-right"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-linea">
                    @forelse (($resultados ?? []) as $resultado)
                            <tr data-fila class="fila">
                                <td class="td"><div class="flex items-center gap-3">
                                        <span class="avatar h-10 w-10"><i class="fa-solid fa-list-check text-sm"></i></span>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-azul-900">{{ data_get($resultado, 'nombre') }}</p>
                                            <p class="mt-0.5 truncate text-xs text-slate-500">{{ data_get($resultado, 'codigo') ?: 'Sin código' }}</p>
                                        </div>
                                    </div></td>
                                <td class="td text-slate-600">{{ data_get($resultado, 'competition.nombre', 'Sin competencia') }}</td>
                                <td class="td max-w-xs text-slate-500">{{ \Illuminate\Support\Str::limit(data_get($resultado, 'descripcion') ?: '—', 60) }}</td>
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => route('resultados.show', data_get($resultado, 'id')),
                                        'editar' => route('resultados.edit', data_get($resultado, 'id')),
                                        'eliminar' => route('resultados.destroy', data_get($resultado, 'id')),
                                        'confirmar' => '¿Eliminar este resultado? No se podrá si ya tiene calificaciones.',
                                    ])
                                </td>
                            </tr>
                    @empty
                        @include('Includes.fila-vacia', [
                            'columnas' => 4,
                            'icono' => 'fa-list-check',
                            'mensaje' => 'Aún no hay resultados de aprendizaje',
                            'boton' => ['url' => route('resultados.create'), 'texto' => 'Nuevo resultado'],
                        ])
                    @endforelse
                    @include('Includes.sin-resultados', ['columnas' => 4])
                </tbody>
            </table>
        </div>
    </div>
@endsection
