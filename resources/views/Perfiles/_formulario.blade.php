{{-- Campos del perfil según el tipo (admins, aspirantes) --}}
@php
    $perfil = $perfil ?? [];

    // Usuarios con el rol del perfil que aún no lo tienen (más el usuario actual al editar)
    $usuarios = collect($usuarios ?? [])->filter(fn($u) =>
        data_get($u, 'rol') === $config['rol']
        && (data_get($u, 'id') == data_get($perfil, 'user_id') || !data_get($u, $config['relacion']))
    )->values()->all();
    $epsLista = ['SURA', 'Sanitas', 'Nueva EPS', 'Salud Total', 'Compensar', 'Coosalud', 'Emssanar'];
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    {{-- Usuario dueño del perfil --}}
    <div class="sm:col-span-2">
        <label for="user_id" class="etiqueta">Usuario ({{ $config['rol'] }})</label>
        <select id="user_id" name="user_id" required class="campo">
            <option value="">Selecciona un usuario</option>
            @foreach ($usuarios as $usuario)
                <option value="{{ data_get($usuario, 'id') }}" @selected(old('user_id', data_get($perfil, 'user_id')) == data_get($usuario, 'id'))>
                    {{ Vista::nombre($usuario) }} — {{ data_get($usuario, 'identificacion') }}
                </option>
            @endforeach
        </select>
        <p class="ayuda">
            Solo aparecen usuarios con rol {{ $config['rol'] }} que aún no tienen perfil.
            <a href="{{ route('usuarios.create') }}" class="enlace">Crear usuario</a>
        </p>
    </div>

    @if ($tipo === 'admins')
        <div>
            <label for="cargo" class="etiqueta">Cargo</label>
            <input type="text" id="cargo" name="cargo" required maxlength="255" class="campo"
                value="{{ old('cargo', data_get($perfil, 'cargo')) }}" placeholder="Ej. Coordinador académico">
        </div>
        <div>
            <label for="ubicacion_oficina" class="etiqueta">Ubicación de la oficina</label>
            <input type="text" id="ubicacion_oficina" name="ubicacion_oficina" required maxlength="255" class="campo"
                value="{{ old('ubicacion_oficina', data_get($perfil, 'ubicacion_oficina')) }}" placeholder="Ej. Bloque A, oficina 204">
        </div>
        <div class="sm:col-span-2">
            <label for="direccion" class="etiqueta">Dirección <span class="font-normal text-slate-400">(opcional)</span></label>
            <input type="text" id="direccion" name="direccion" maxlength="255" class="campo"
                value="{{ old('direccion', data_get($perfil, 'direccion')) }}">
        </div>
    @endif

    @if ($tipo === 'aspirantes')
        <div class="sm:col-span-2">
            <label for="eps" class="etiqueta">EPS</label>
            <select id="eps" name="eps" required class="campo">
                <option value="">Selecciona una EPS</option>
                @foreach ($epsLista as $valor)
                    <option value="{{ $valor }}" @selected(old('eps', data_get($perfil, 'eps')) === $valor)>{{ $valor }}</option>
                @endforeach
            </select>
        </div>
        @foreach (['certificado_eps' => 'Certificado de EPS', 'certificado_bachiller' => 'Diploma de bachiller', 'certificado_icfes' => 'Resultado ICFES'] as $campo => $texto)
            <div class="sm:col-span-2">
                <label for="{{ $campo }}" class="etiqueta">{{ $texto }} <span class="font-normal text-slate-400">(PDF o imagen, máx. 4 MB)</span></label>
                <input type="file" id="{{ $campo }}" name="{{ $campo }}" accept=".pdf,.png,.jpg,.jpeg"
                    class="campo file:mr-4 file:rounded-lg file:border-0 file:bg-sena-50 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-sena-700">
                @if (data_get($perfil, $campo))
                    <a href="{{ Vista::archivo(data_get($perfil, $campo)) }}" target="_blank"
                        class="mt-1.5 inline-flex items-center gap-1 text-xs font-semibold text-sena-700 hover:underline">
                        <i class="fa-solid fa-paperclip"></i> Ver archivo actual
                    </a>
                @endif
            </div>
        @endforeach
    @endif
</div>
