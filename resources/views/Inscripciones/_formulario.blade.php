{{-- Campos compartidos por crear y editar inscripción --}}
@php
    $inscripcion = $inscripcion ?? [];
    $estados = ['Registrado', 'En proceso', 'Seleccionado', 'Rechazado', 'Cancelada'];
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="aspirant_id" class="etiqueta">Aspirante</label>
        <select id="aspirant_id" name="aspirant_id" required class="campo">
            <option value="">Selecciona un aspirante</option>
            @foreach ($aspirantes as $aspirante)
                <option value="{{ data_get($aspirante, 'id') }}" @selected(old('aspirant_id', data_get($inscripcion, 'aspirant_id')) == data_get($aspirante, 'id'))>
                    {{ Vista::nombre(data_get($aspirante, 'user')) }} — {{ data_get($aspirante, 'user.identificacion') }}
                </option>
            @endforeach
        </select>
        @if (empty($aspirantes))
            <p class="ayuda">No hay perfiles de aspirante. Créalos en
                <a href="{{ route('perfiles.index', 'aspirantes') }}" class="font-semibold text-sena-700 underline">Perfiles › Aspirantes</a>.</p>
        @endif
    </div>

    <div class="sm:col-span-2">
        <label for="offer_id" class="etiqueta">Oferta de formación</label>
        <select id="offer_id" name="offer_id" required class="campo">
            <option value="">Selecciona una oferta</option>
            @foreach ($ofertas as $oferta)
                <option value="{{ data_get($oferta, 'id') }}" @selected(old('offer_id', data_get($inscripcion, 'offer_id')) == data_get($oferta, 'id'))>
                    {{ data_get($oferta, 'program.nombre', 'Oferta #' . data_get($oferta, 'id')) }}
                    — convocatoria {{ Vista::fecha(data_get($oferta, 'fecha_convocatoria')) }} a {{ Vista::fecha(data_get($oferta, 'fecha_fin_convocatoria')) }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="estado" class="etiqueta">Estado</label>
        <select id="estado" name="estado" required class="campo">
            @foreach ($estados as $estado)
                <option value="{{ $estado }}" @selected(old('estado', data_get($inscripcion, 'estado', 'Registrado')) === $estado)>{{ $estado }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="Fecha_inscripcion" class="etiqueta">Fecha de inscripción <span class="font-normal text-slate-400">(opcional)</span></label>
        <input type="date" id="Fecha_inscripcion" name="Fecha_inscripcion" class="campo"
            value="{{ old('Fecha_inscripcion', Vista::fechaInput(data_get($inscripcion, 'Fecha_inscripcion'))) }}">
        <p class="ayuda">Si la dejas vacía, la API usa la fecha actual.</p>
    </div>
</div>
