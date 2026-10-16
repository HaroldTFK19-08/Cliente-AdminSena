{{-- Campos compartidos por crear y editar ficha --}}
@php
    $ficha = $ficha ?? [];
    $planta = array_filter($instructores, fn($i) => strtolower((string) data_get($i, 'tipo_instructor')) === 'planta');
    $adicionales = old('teacher_ids', collect(data_get($ficha, 'teachers', []))->pluck('id')->all());
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="codigo" class="etiqueta">Código de la ficha</label>
        <input type="text" id="codigo" name="codigo" value="{{ old('codigo', data_get($ficha, 'codigo')) }}" required
            maxlength="255" placeholder="Ej. 2758412" class="campo">
    </div>

    <div>
        <label for="capacidad_aprendices" class="etiqueta">Capacidad de aprendices</label>
        <input type="number" id="capacidad_aprendices" name="capacidad_aprendices" min="1" required
            value="{{ old('capacidad_aprendices', data_get($ficha, 'capacidad_aprendices')) }}" placeholder="Ej. 30"
            class="campo">
    </div>

    <div class="sm:col-span-2">
        <label for="program_id" class="etiqueta">Programa de formación</label>
        <select id="program_id" name="program_id" required class="campo">
            <option value="">Selecciona un programa</option>
            @foreach ($programas as $programa)
                <option value="{{ data_get($programa, 'id') }}" @selected(old('program_id', data_get($ficha, 'program_id')) == data_get($programa, 'id'))>
                    {{ data_get($programa, 'nombre') }} ({{ data_get($programa, 'codigo_programa') }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <label for="teacher_id" class="etiqueta">Instructor líder</label>
        <select id="teacher_id" name="teacher_id" required class="campo">
            <option value="">Selecciona un instructor de planta</option>
            @foreach ($planta as $instructor)
                <option value="{{ data_get($instructor, 'id') }}" @selected(old('teacher_id', data_get($ficha, 'teacher_id')) == data_get($instructor, 'id'))>
                    {{ Vista::nombre(data_get($instructor, 'user')) }} — {{ data_get($instructor, 'especialidad') }}
                </option>
            @endforeach
        </select>
        <p class="ayuda">La API solo acepta instructores de tipo <strong>Planta</strong> como líder de ficha.</p>
    </div>

    <div class="sm:col-span-2">
        <span class="etiqueta">Otros instructores de la ficha</span>
        <div class="grid max-h-64 gap-2 overflow-y-auto sm:grid-cols-2">
            @forelse ($instructores as $instructor)
                <label class="opcion">
                    <input type="checkbox" name="teacher_ids[]" value="{{ data_get($instructor, 'id') }}"
                        @checked(in_array(data_get($instructor, 'id'), (array) $adicionales))
                        class="casilla">
                    <span>
                        {{ Vista::nombre(data_get($instructor, 'user')) }}
                        <span class="text-xs text-slate-400">({{ data_get($instructor, 'tipo_instructor') }})</span>
                    </span>
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
