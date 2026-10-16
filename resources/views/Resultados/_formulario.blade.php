{{-- Campos compartidos por crear y editar resultado --}}
@php
    $resultado = $resultado ?? [];
    $creando = !data_get($resultado, 'id');
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="competition_id" class="etiqueta">Competencia</label>
        <select id="competition_id" name="competition_id" required class="campo">
            <option value="">Selecciona una competencia</option>
            @foreach ($competencias as $competencia)
                <option value="{{ data_get($competencia, 'id') }}"
                    @selected(old('competition_id', data_get($resultado, 'competition_id', request('competition_id'))) == data_get($competencia, 'id'))>
                    {{ data_get($competencia, 'nombre') }} {{ data_get($competencia, 'codigo') ? '(' . data_get($competencia, 'codigo') . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="codigo" class="etiqueta">Código <span class="font-normal text-slate-400">(opcional)</span></label>
        <input type="text" id="codigo" name="codigo" value="{{ old('codigo', data_get($resultado, 'codigo')) }}"
            maxlength="255" placeholder="Ej. RA-01" class="campo">
    </div>

    <div>
        <label for="nombre" class="etiqueta">Nombre del resultado</label>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', data_get($resultado, 'nombre')) }}" required
            maxlength="255" placeholder="Ej. Diseñar el modelo de datos" class="campo">
    </div>

    <div class="sm:col-span-2">
        <label for="descripcion" class="etiqueta">Descripción <span class="font-normal text-slate-400">(opcional)</span></label>
        <textarea id="descripcion" name="descripcion" rows="3" class="campo">{{ old('descripcion', data_get($resultado, 'descripcion')) }}</textarea>
    </div>

    @if ($creando)
        <div>
            <label for="cantidad" class="etiqueta">Cantidad a crear</label>
            <input type="number" id="cantidad" name="cantidad" min="1" max="30" value="{{ old('cantidad', 1) }}" class="campo">
            <p class="ayuda">Con más de 1, la API numera el nombre y el código (ej. "RA-01-1", "RA-01-2"...).</p>
        </div>
    @endif
</div>
