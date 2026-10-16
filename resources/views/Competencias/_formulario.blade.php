{{-- Campos compartidos por crear y editar competencia --}}
@php
    $competencia = $competencia ?? [];
    $seleccionados = old('teacher_ids', collect(data_get($competencia, 'teachers', []))->pluck('id')->all());
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="codigo" class="etiqueta">Código <span class="font-normal text-slate-400">(opcional)</span></label>
        <input type="text" id="codigo" name="codigo" value="{{ old('codigo', data_get($competencia, 'codigo')) }}"
            maxlength="255" placeholder="Ej. 220501046" class="campo">
    </div>

    <div>
        <label for="nombre" class="etiqueta">Nombre de la competencia</label>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', data_get($competencia, 'nombre')) }}" required
            maxlength="255" placeholder="Ej. Construir el sistema de información" class="campo">
    </div>

    <div class="sm:col-span-2">
        <label for="descripcion" class="etiqueta">Descripción <span class="font-normal text-slate-400">(opcional)</span></label>
        <textarea id="descripcion" name="descripcion" rows="3" class="campo"
            placeholder="Describe brevemente la competencia">{{ old('descripcion', data_get($competencia, 'descripcion')) }}</textarea>
    </div>

    <div>
        <label for="fecha_inicio" class="etiqueta">Fecha de inicio</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required class="campo"
            value="{{ old('fecha_inicio', Vista::fechaInput(data_get($competencia, 'fecha_inicio'))) }}">
    </div>

    <div>
        <label for="fecha_fin" class="etiqueta">Fecha de finalización</label>
        <input type="date" id="fecha_fin" name="fecha_fin" required class="campo"
            value="{{ old('fecha_fin', Vista::fechaInput(data_get($competencia, 'fecha_fin'))) }}">
    </div>

    <div class="sm:col-span-2">
        <label for="teacher_id" class="etiqueta">Instructor líder <span class="font-normal text-slate-400">(opcional)</span></label>
        <select id="teacher_id" name="teacher_id" class="campo">
            <option value="">Sin instructor líder</option>
            @foreach ($instructores as $instructor)
                <option value="{{ data_get($instructor, 'id') }}" @selected(old('teacher_id', data_get($competencia, 'teacher_id')) == data_get($instructor, 'id'))>
                    {{ Vista::nombre(data_get($instructor, 'user')) }} — {{ data_get($instructor, 'especialidad') }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <span class="etiqueta">Instructores que orientan la competencia</span>
        <div class="grid max-h-64 gap-2 overflow-y-auto sm:grid-cols-2">
            @forelse ($instructores as $instructor)
                <label class="opcion">
                    <input type="checkbox" name="teacher_ids[]" value="{{ data_get($instructor, 'id') }}"
                        @checked(in_array(data_get($instructor, 'id'), (array) $seleccionados))
                        class="casilla">
                    <span>{{ Vista::nombre(data_get($instructor, 'user')) }}</span>
                </label>
            @empty
                <p class="text-sm text-slate-500">No hay instructores registrados en la API.</p>
            @endforelse
        </div>
        <p class="ayuda">El instructor líder queda marcado automáticamente en esta lista.</p>
    </div>
</div>

@push('scripts')
    <script>
        // La API guarda los instructores que vienen en teacher_ids: se marca siempre al líder en la lista.
        (function() {
            const lider = document.getElementById('teacher_id');
            if (!lider) return;
            const marcarLider = () => {
                const casilla = document.querySelector('input[name="teacher_ids[]"][value="' + lider.value + '"]');
                if (casilla) casilla.checked = true;
            };
            lider.addEventListener('change', marcarLider);
            marcarLider();
        })();
    </script>
@endpush
