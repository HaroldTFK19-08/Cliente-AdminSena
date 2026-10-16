{{-- Campos compartidos por crear y editar asignación de equipo --}}
@php
    $asignacion = $asignacion ?? [];
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="equipment_id" class="etiqueta">Equipo</label>
        <select id="equipment_id" name="equipment_id" required class="campo">
            <option value="">Selecciona un equipo</option>
            @foreach (collect($equipos)->groupBy('environment.nombre') as $ambiente => $grupo)
                <optgroup label="{{ $ambiente ?: 'Sin ambiente' }}">
                    @foreach ($grupo as $equipo)
                        <option value="{{ data_get($equipo, 'id') }}" @selected(old('equipment_id', data_get($asignacion, 'equipment_id')) == data_get($equipo, 'id'))>
                            {{ data_get($equipo, 'name') }} {{ data_get($equipo, 'brand') ? '· ' . data_get($equipo, 'brand') : '' }}
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
                <option value="{{ data_get($aprendiz, 'id') }}" @selected(old('apprentice_id', data_get($asignacion, 'apprentice_id')) == data_get($aprendiz, 'id'))>
                    {{ Vista::nombre(data_get($aprendiz, 'user')) }} — Ficha {{ data_get($aprendiz, 'coursegroup.codigo', 'N/A') }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="fecha_asignacion" class="etiqueta">Fecha de asignación</label>
        <input type="date" id="fecha_asignacion" name="fecha_asignacion" required class="campo"
            value="{{ old('fecha_asignacion', Vista::fechaInput(data_get($asignacion, 'fecha_asignacion')) ?: now()->format('Y-m-d')) }}">
    </div>

    <div>
        <label for="fecha_devolucion" class="etiqueta">Fecha de devolución <span class="font-normal text-slate-400">(opcional)</span></label>
        <input type="date" id="fecha_devolucion" name="fecha_devolucion" class="campo"
            value="{{ old('fecha_devolucion', Vista::fechaInput(data_get($asignacion, 'fecha_devolucion'))) }}">
    </div>

    <div>
        <label for="Estado" class="etiqueta">Estado</label>
        <select id="Estado" name="Estado" required class="campo">
            @foreach (['Activo', 'Inactivo'] as $estado)
                <option value="{{ $estado }}" @selected(old('Estado', data_get($asignacion, 'Estado', 'Activo')) === $estado)>{{ $estado }}</option>
            @endforeach
        </select>
    </div>
</div>
