{{-- Campos compartidos por crear y editar usuario --}}
@php
    $usuario = $usuario ?? [];
    $editando = (bool) data_get($usuario, 'id');
    $foto = Vista::archivo(data_get($usuario, 'foto_perfil'));
@endphp

<div class="space-y-7">
    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Datos personales</h3>
            <p class="seccion-ayuda">Como aparecen en el documento de identidad.</p>
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            @foreach (['nombre_1' => ['Primer nombre', true], 'nombre_2' => ['Segundo nombre', false], 'apellido_1' => ['Primer apellido', true], 'apellido_2' => ['Segundo apellido', false]] as $campo => [$texto, $obligatorio])
                <div>
                    <label for="{{ $campo }}" class="etiqueta">{{ $texto }}</label>
                    <input type="text" id="{{ $campo }}" name="{{ $campo }}" maxlength="20" class="campo"
                        value="{{ old($campo, data_get($usuario, $campo)) }}" {{ $obligatorio ? 'required' : '' }}>
                </div>
            @endforeach
            <div>
                <label for="tipo_identificacion" class="etiqueta">Tipo de documento</label>
                <select id="tipo_identificacion" name="tipo_identificacion" required class="campo">
                    @foreach (['CC' => 'Cédula de ciudadanía', 'TI' => 'Tarjeta de identidad', 'CE' => 'Cédula de extranjería', 'PPT' => 'Permiso por protección temporal'] as $valor => $texto)
                        <option value="{{ $valor }}" @selected(old('tipo_identificacion', data_get($usuario, 'tipo_identificacion', 'CC')) === $valor)>{{ $texto }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="identificacion" class="etiqueta">Número de documento</label>
                <input type="text" id="identificacion" name="identificacion" required maxlength="255"
                    inputmode="numeric" class="campo"
                    value="{{ old('identificacion', data_get($usuario, 'identificacion')) }}">
            </div>
        </div>
    </section>

    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Acceso al sistema</h3>
            <p class="seccion-ayuda">Según el rol se piden sus datos propios más abajo.</p>
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="email" class="etiqueta">Correo electrónico</label>
                <input type="email" id="email" name="email" required maxlength="255" class="campo"
                    placeholder="nombre@correo.com" value="{{ old('email', data_get($usuario, 'email')) }}">
            </div>
            <div class="sm:col-span-2">
                <span class="etiqueta">Rol</span>
                <div class="grid gap-2 sm:grid-cols-4">
                    @foreach (['Instructor' => ['Instructor', 'fa-chalkboard-user'], 'Aprendiz' => ['Aprendiz', 'fa-user-graduate'], 'Aspirante' => ['Aspirante', 'fa-user-clock']] as $valor => [$texto, $icono])
                        <label class="opcion">
                            <input type="radio" name="rol" value="{{ $valor }}" class="sr-only"
                                @checked(old('rol', data_get($usuario, 'rol', 'Aprendiz')) === $valor)>
                            <i class="fa-solid {{ $icono }} w-4 text-center text-sena-700"></i>
                            <span class="font-medium text-azul-900">{{ $texto }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div>
                <label for="password" class="etiqueta">Contraseña</label>
                <input type="password" id="password" name="password" minlength="8" class="campo"
                    autocomplete="new-password" {{ $editando ? '' : 'required' }}>
                <p class="ayuda">{{ $editando ? 'Déjala vacía para conservar la actual.' : 'Mínimo 8 caracteres.' }}
                </p>
            </div>
            <div>
                <label for="password_confirmation" class="etiqueta">Repite la contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" minlength="8"
                    class="campo" autocomplete="new-password" {{ $editando ? '' : 'required' }}>
            </div>
        </div>
    </section>

    {{-- Atributos del rol: solo se muestra (y se envía) el bloque del rol elegido --}}
    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Datos del rol</h3>
            <p class="seccion-ayuda">Se guardan junto con la cuenta en el perfil del aprendiz o del instructor.</p>
        </div>
        <div>
            <div data-rol-campos="Aprendiz">
                @include('Includes.campos-aprendiz', ['datos' => data_get($usuario, 'apprentice', []), 'fichas' => $fichas ?? []])
            </div>
            <div data-rol-campos="Instructor">
                @include('Includes.campos-instructor', ['datos' => data_get($usuario, 'teacher', []), 'areas' => $areas ?? []])
            </div>
            <p data-sin-campos-rol class="hidden rounded-xl bg-papel p-4 text-sm text-slate-500">
                <i class="fa-solid fa-circle-info mr-1 text-slate-400"></i>
                El aspirante completa su EPS y certificados en
                <a href="{{ route('perfiles.index', 'aspirantes') }}" class="enlace">Perfiles › Aspirantes</a>.
            </p>
        </div>
    </section>

    <section class="seccion">
        <div>
            <h3 class="seccion-titulo">Foto de perfil</h3>
            <p class="seccion-ayuda">Opcional. PNG, JPG o WEBP de máximo 2 MB.</p>
        </div>
        <div class="flex items-center gap-4">
            <span
                class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-azul-50 text-lg font-bold text-azul-800">
                @if ($foto)
                    <img src="{{ $foto }}" alt="Foto actual" class="h-full w-full object-cover">
                @else
                    {{ $editando ? Vista::iniciales($usuario) : '' }}<i
                        class="fa-regular fa-user {{ $editando ? 'hidden' : '' }}"></i>
                @endif
            </span>
            <input type="file" id="foto_perfil" name="foto_perfil" accept=".png,.jpg,.jpeg,.webp" class="campo">
        </div>
    </section>
</div>

@include('Includes.campos-por-rol')

@push('scripts')
    <script>
        (function() {
            const pass = document.getElementById('password');
            const passConf = document.getElementById('password_confirmation');
            const form = pass ? pass.closest('form') : null;
            if (!pass || !passConf || !form) return;

            form.addEventListener('submit', function(e) {
                if (pass.value && pass.value !== passConf.value) {
                    e.preventDefault();
                    alert('Las contraseñas no coinciden. Por favor verifícalas antes de continuar.');
                    passConf.focus();
                }
            });
        })();
    </script>
@endpush
