{{-- Campos compartidos por crear y editar calificación --}}
@php
    $calificacion = $calificacion ?? [];
    $estados = ['Aprobado', 'Reprobado', 'Pendiente'];
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="result_id" class="etiqueta">Resultado de aprendizaje</label>
        <select id="result_id" name="result_id" required class="campo">
            <option value="">Selecciona un resultado</option>
            @foreach (collect($resultados)->groupBy('competition.nombre') as $competencia => $grupo)
                <optgroup label="{{ $competencia ?: 'Sin competencia' }}">
                    @foreach ($grupo as $resultado)
                        <option value="{{ data_get($resultado, 'id') }}"
                            @selected(old('result_id', data_get($calificacion, 'result_id', request('result_id'))) == data_get($resultado, 'id'))>
                            {{ data_get($resultado, 'nombre') }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <label for="apprentice_id" class="etiqueta">Aprendiz</label>
        <select id="apprentice_id" name="apprentice_id" required class="campo">
            <option value="">Selecciona un aprendiz</option>
            @foreach ($aprendices as $aprendiz)
                <option value="{{ data_get($aprendiz, 'id') }}" @selected(old('apprentice_id', data_get($calificacion, 'apprentice_id')) == data_get($aprendiz, 'id'))>
                    {{ Vista::nombre(data_get($aprendiz, 'user')) }} — Ficha {{ data_get($aprendiz, 'coursegroup.codigo', 'N/A') }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="estado_resultado" class="etiqueta">Estado del resultado</label>
        <select id="estado_resultado" name="estado_resultado" required class="campo">
            @foreach ($estados as $estado)
                <option value="{{ $estado }}" @selected(old('estado_resultado', data_get($calificacion, 'estado_resultado', 'Pendiente')) === $estado)>{{ $estado }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="teacher_id" class="etiqueta">Instructor que califica <span class="font-normal text-slate-400">(opcional)</span></label>
        <select id="teacher_id" name="teacher_id" class="campo">
            <option value="">Sin instructor</option>
            @foreach ($instructores as $instructor)
                <option value="{{ data_get($instructor, 'id') }}" @selected(old('teacher_id', data_get($calificacion, 'teacher_id')) == data_get($instructor, 'id'))>
                    {{ Vista::nombre(data_get($instructor, 'user')) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <label for="comentarios" class="etiqueta">Comentarios <span class="font-normal text-slate-400">(opcional)</span></label>
        <textarea id="comentarios" name="comentarios" rows="3" maxlength="2000" class="campo"
            placeholder="Observaciones sobre el desempeño del aprendiz">{{ old('comentarios', data_get($calificacion, 'comentarios')) }}</textarea>
    </div>
</div>

@if (!data_get($calificacion, 'id'))
    <p class="rounded-xl bg-blue-50 p-4 text-xs text-blue-700">
        <i class="fa-solid fa-circle-info mr-1"></i>
        Si el aprendiz ya tiene calificación para ese resultado, la API la actualiza en lugar de crear otra.
    </p>
@endif
