{{--
    Atributos del instructor (tabla teachers): área, especialidad, tipo y fechas.
    Parámetros: datos (perfil de instructor), areas, (opc.) clase, claseEtiqueta, prefijo
--}}
@php
    $datos = $datos ?? [];
    $areas = $areas ?? [];
    $clase = $clase ?? 'campo';
    $claseEtiqueta = $claseEtiqueta ?? 'etiqueta';
    $prefijo = $prefijo ?? 'instructor';
    $obligatorio = $claseEtiqueta === 'etiqueta' ? '' : ' <span class="text-red-500">*</span>';
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="{{ $prefijo }}_area_id" class="{{ $claseEtiqueta }}">Área{!! $obligatorio !!}</label>
        <select id="{{ $prefijo }}_area_id" name="area_id" @error('area_id') aria-invalid="true" @enderror required class="{{ $clase }}">
            <option value="">Selecciona un área</option>
            @foreach ($areas as $area)
                <option value="{{ data_get($area, 'id') }}" @selected(old('area_id', data_get($datos, 'area_id')) == data_get($area, 'id'))>
                    {{ data_get($area, 'nombre') }}
                </option>
            @endforeach
        </select>
        @if (empty($areas))
            <p class="ayuda">No hay áreas registradas todavía.</p>
        @endif
    </div>
    <div>
        <label for="{{ $prefijo }}_tipo_instructor" class="{{ $claseEtiqueta }}">Tipo de instructor{!! $obligatorio !!}</label>
        <select id="{{ $prefijo }}_tipo_instructor" name="tipo_instructor" @error('tipo_instructor') aria-invalid="true" @enderror required class="{{ $clase }}">
            @foreach (['Planta', 'Contratista'] as $valor)
                <option value="{{ $valor }}" @selected(old('tipo_instructor', data_get($datos, 'tipo_instructor', 'Planta')) === $valor)>{{ $valor }}</option>
            @endforeach
        </select>
    </div>
    <div class="sm:col-span-2">
        <label for="{{ $prefijo }}_especialidad" class="{{ $claseEtiqueta }}">Especialidad{!! $obligatorio !!}</label>
        <input type="text" id="{{ $prefijo }}_especialidad" name="especialidad" @error('especialidad') aria-invalid="true" @enderror required maxlength="150" class="{{ $clase }}"
            value="{{ old('especialidad', data_get($datos, 'especialidad')) }}" placeholder="Ej. Desarrollo de software">
    </div>
    <div>
        <label for="{{ $prefijo }}_fecha_inicio" class="{{ $claseEtiqueta }}">Fecha de inicio{!! $obligatorio !!}</label>
        <input type="date" id="{{ $prefijo }}_fecha_inicio" name="fecha_inicio" @error('fecha_inicio') aria-invalid="true" @enderror required class="{{ $clase }}"
            value="{{ old('fecha_inicio', Vista::fechaInput(data_get($datos, 'fecha_inicio'))) }}">
    </div>
    <div>
        <label for="{{ $prefijo }}_fecha_fin" class="{{ $claseEtiqueta }}">Fecha de finalización <span class="font-normal text-slate-400">(opcional)</span></label>
        <input type="date" id="{{ $prefijo }}_fecha_fin" name="fecha_fin" @error('fecha_fin') aria-invalid="true" @enderror class="{{ $clase }}"
            value="{{ old('fecha_fin', Vista::fechaInput(data_get($datos, 'fecha_fin'))) }}">
    </div>
</div>
