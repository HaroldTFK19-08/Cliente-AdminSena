{{--
    Atributos del aprendiz (tabla apprentices): ficha, estado y fechas.
    Parámetros: datos (perfil de aprendiz), fichas, (opc.) conEstado, clase, claseEtiqueta, prefijo
    El prefijo evita ids repetidos cuando el formulario también tiene los campos de instructor.
--}}
@php
    $datos = $datos ?? [];
    $fichas = $fichas ?? [];
    $conEstado = $conEstado ?? true;
    $clase = $clase ?? 'campo';
    $claseEtiqueta = $claseEtiqueta ?? 'etiqueta';
    $prefijo = $prefijo ?? 'aprendiz';
    // En el registro público las etiquetas no son .etiqueta: el asterisco se pone a mano
    $obligatorio = $claseEtiqueta === 'etiqueta' ? '' : ' <span class="text-red-500">*</span>';
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div class="{{ $conEstado ? '' : 'sm:col-span-2' }}">
        <label for="{{ $prefijo }}_course_group_id" class="{{ $claseEtiqueta }}">Ficha{!! $obligatorio !!}</label>
        <select id="{{ $prefijo }}_course_group_id" name="course_group_id" @error('course_group_id') aria-invalid="true" @enderror required class="{{ $clase }}">
            <option value="">Selecciona una ficha</option>
            @foreach ($fichas as $ficha)
                <option value="{{ data_get($ficha, 'id') }}" @selected(old('course_group_id', data_get($datos, 'course_group_id')) == data_get($ficha, 'id'))>
                    {{ data_get($ficha, 'codigo') }} — {{ data_get($ficha, 'program.nombre', 'Sin programa') }}
                </option>
            @endforeach
        </select>
        @if (empty($fichas))
            <p class="ayuda">No hay fichas registradas todavía.</p>
        @endif
    </div>
    @if ($conEstado)
        <div>
            <label for="{{ $prefijo }}_estado" class="{{ $claseEtiqueta }}">Estado</label>
            <select id="{{ $prefijo }}_estado" name="estado" @error('estado') aria-invalid="true" @enderror required class="{{ $clase }}">
                @foreach (['Activo', 'Retirado', 'Certificado'] as $valor)
                    <option value="{{ $valor }}" @selected(old('estado', data_get($datos, 'estado', 'Activo')) === $valor)>{{ $valor }}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div>
        <label for="{{ $prefijo }}_fecha_inicio" class="{{ $claseEtiqueta }}">Inicio de formación{!! $obligatorio !!}</label>
        <input type="date" id="{{ $prefijo }}_fecha_inicio" name="fecha_inicio" @error('fecha_inicio') aria-invalid="true" @enderror required class="{{ $clase }}"
            value="{{ old('fecha_inicio', Vista::fechaInput(data_get($datos, 'fecha_inicio'))) }}">
    </div>
    <div>
        <label for="{{ $prefijo }}_fecha_fin" class="{{ $claseEtiqueta }}">Fin de formación <span class="font-normal text-slate-400">(opcional)</span></label>
        <input type="date" id="{{ $prefijo }}_fecha_fin" name="fecha_fin" @error('fecha_fin') aria-invalid="true" @enderror class="{{ $clase }}"
            value="{{ old('fecha_fin', Vista::fechaInput(data_get($datos, 'fecha_fin'))) }}">
    </div>
</div>
