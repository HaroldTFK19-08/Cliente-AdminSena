@extends('Layouts.Admin')

@section('title', 'Competencias - AdminSena')

@section('contenido')
    @include('Includes.encabezado', [
        'titulo' => 'Competencias',
        'descripcion' => 'Competencias de formación con su vigencia e instructores.',
        'boton' => ['url' => route('competencias.create'), 'texto' => 'Nueva competencia'],
    ])

    <div class="tarjeta overflow-hidden">
        @include('Includes.barra-busqueda', [
            'titulo' => 'Competencias registradas',
            'placeholder' => 'Buscar por código, nombre o instructor',
            'total' => count($competencias ?? []),
        ])

        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-sm">
                <thead>
                    <tr>
                            <th class="th">Competencia</th>
                            <th class="th">Instructor líder</th>
                            <th class="th">Equipo docente</th>
                            <th class="th">Vigencia</th>
                            <th class="th w-px text-right"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-linea">
                    @forelse (($competencias ?? []) as $competencia)
                            <tr data-fila class="fila">
                                <td class="td"><div class="flex items-center gap-3">
                                        <span class="avatar h-10 w-10"><i class="fa-solid fa-book-open text-sm"></i></span>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-azul-900">{{ data_get($competencia, 'nombre') }}</p>
                                            <p class="mt-0.5 truncate text-xs text-slate-500">{{ data_get($competencia, 'codigo') ?: 'Sin código' }}</p>
                                        </div>
                                    </div></td>
                                <td class="td text-slate-600">{{ Vista::nombre(data_get($competencia, 'teacher.user'), 'Sin asignar') }}</td>
                                <td class="td text-slate-600"><i class="fa-solid fa-chalkboard-user mr-2 text-xs text-slate-400"></i>{{ count(data_get($competencia, 'teachers', [])) }}</td>
                                <td class="td whitespace-nowrap text-slate-500">{{ Vista::fechaCorta(data_get($competencia, 'fecha_inicio')) }} – {{ Vista::fechaCorta(data_get($competencia, 'fecha_fin')) }}</td>
                                <td class="td">
                                    @include('Includes.acciones', [
                                        'ver' => route('competencias.show', data_get($competencia, 'id')),
                                        'editar' => route('competencias.edit', data_get($competencia, 'id')),
                                        'eliminar' => route('competencias.destroy', data_get($competencia, 'id')),
                                        'confirmar' => '¿Eliminar esta competencia?',
                                    ])
                                </td>
                            </tr>
                    @empty
                        @include('Includes.fila-vacia', [
                            'columnas' => 5,
                            'icono' => 'fa-book-open',
                            'mensaje' => 'Aún no hay competencias',
                            'boton' => ['url' => route('competencias.create'), 'texto' => 'Nueva competencia'],
                        ])
                    @endforelse
                    @include('Includes.sin-resultados', ['columnas' => 5])
                </tbody>
            </table>
        </div>
    </div>
@endsection
