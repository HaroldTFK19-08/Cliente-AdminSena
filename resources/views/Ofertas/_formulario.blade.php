{{-- Campos compartidos por crear y editar oferta --}}
@php
    $oferta = $oferta ?? [];
    $fechas = [
        'fecha_lanzamiento' => ['Lanzamiento', null],
        'fecha_convocatoria' => ['Abre la convocatoria', 'Igual o después del lanzamiento.'],
        'fecha_fin_convocatoria' => ['Cierra la convocatoria', 'Después de la apertura.'],
        'fecha_primera_prueba' => ['Primera prueba', 'Después del cierre.'],
        'fecha_segunda_prueba' => ['Segunda prueba', 'Después de la primera prueba.'],
        'fecha_seleccionados' => ['Publicación de seleccionados', 'Igual o después de la segunda prueba.'],
    ];
    $imagenActual = Vista::archivo(data_get($oferta, 'imagen'));
@endphp

<div class="space-y-7">
    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Programa y cupos</h3>
            <p class="seccion-ayuda">Qué se ofrece y para cuántas personas.</p>
        </div>
        <div class="grid gap-5 sm:grid-cols-3">
            <div class="sm:col-span-2">
                <label for="program_id" class="etiqueta">Programa de formación</label>
                <select id="program_id" name="program_id" required class="campo">
                    <option value="">Elige un programa</option>
                    @foreach ($programas ?? [] as $programa)
                        <option value="{{ data_get($programa, 'id') }}" @selected(old('program_id', data_get($oferta, 'program_id')) == data_get($programa, 'id'))>
                            {{ data_get($programa, 'nombre') }} ({{ data_get($programa, 'nivel_programa') === 'Tecnologo' ? 'Tecnólogo' : 'Técnico' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="capacidad" class="etiqueta">Cupos</label>
                <input type="number" id="capacidad" name="capacidad" min="1" required placeholder="35"
                    value="{{ old('capacidad', data_get($oferta, 'capacidad')) }}" class="campo">
            </div>
        </div>
    </section>

    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Cronograma</h3>
            <p class="seccion-ayuda">Cada fecha debe ir después de la anterior; así se muestra en el sitio público.</p>
        </div>
        <ol class="grid gap-5 sm:grid-cols-2">
            @foreach ($fechas as $campo => [$texto, $ayuda])
                <li>
                    <label for="{{ $campo }}" class="etiqueta">
                        <span class="mr-1.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-sena-50 text-[11px] font-bold text-sena-700">{{ $loop->iteration }}</span>{{ $texto }}
                    </label>
                    <input type="date" id="{{ $campo }}" name="{{ $campo }}" required class="campo"
                        value="{{ old($campo, Vista::fechaInput(data_get($oferta, $campo))) }}">
                    @if ($ayuda)
                        <p class="ayuda">{{ $ayuda }}</p>
                    @endif
                </li>
            @endforeach
        </ol>
    </section>

    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Imagen y publicación</h3>
            <p class="seccion-ayuda">Solo las ofertas publicadas aparecen en el sitio.</p>
        </div>
        <div class="space-y-5">
            <div class="flex items-center gap-4">
                @if ($imagenActual)
                    <img src="{{ $imagenActual }}" alt="Imagen actual" class="h-16 w-24 shrink-0 rounded-lg object-cover">
                @endif
                <div class="flex-1">
                    <label for="imagen" class="etiqueta">Imagen de la oferta</label>
                    <input type="file" id="imagen" name="imagen" accept=".png,.jpg,.jpeg,.webp" class="campo">
                    <p class="ayuda">{{ $imagenActual ? 'Si no eliges otra se conserva la actual.' : 'PNG, JPG o WEBP de máximo 2 MB.' }}</p>
                </div>
            </div>
            <input type="hidden" name="publicada" value="0">
            <label class="opcion">
                <input type="checkbox" name="publicada" value="1" class="casilla" @checked(old('publicada', data_get($oferta, 'publicada')))>
                <span>
                    <span class="block font-medium text-azul-900">Publicar en el sitio</span>
                    <span class="block text-xs text-slate-500">Los aspirantes podrán verla y prepararse para inscribirse.</span>
                </span>
            </label>
        </div>
    </section>
</div>
