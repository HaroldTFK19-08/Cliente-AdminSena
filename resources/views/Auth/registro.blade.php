@extends('Layouts.Auth')

@section('title', 'Crear cuenta - AdminSena')
@section('ancho', 'max-w-xl')
@section('lema', 'Crea tu cuenta y empieza tu proceso de formación.')
@section('sublema', 'En tres pasos tendrás acceso a las convocatorias del SENA y podrás seguir tu inscripción.')

@section('contenido')
    @php
        $claseCampo = 'w-full rounded-xl border border-gray-300 bg-gray-50/60 px-4 py-3.5 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/10';
        $pasos = ['Tu rol', 'Tus datos', 'Tu acceso'];
    @endphp

    <div class="rounded-3xl border border-gray-200 bg-white p-7 shadow-xl shadow-[#081B28]/5 sm:p-10">
        <h1 class="text-3xl font-extrabold tracking-tight text-[#081B28]">Crear cuenta</h1>
        <p class="mt-2 text-sm text-slate-500">Completa los tres pasos. Te tomará menos de dos minutos.</p>

        {{-- Indicador de pasos --}}
        <ol class="mt-8 flex items-center" data-indicador>
            @foreach ($pasos as $i => $paso)
                <li class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">
                    <span class="flex items-center gap-2.5">
                        <span data-punto="{{ $i }}"
                            class="flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold transition {{ $i === 0 ? 'bg-[#39A900] text-white shadow-lg shadow-[#39A900]/30' : 'bg-gray-100 text-gray-400' }}">
                            {{ $i + 1 }}
                        </span>
                        <span data-nombre="{{ $i }}" class="hidden text-sm font-semibold sm:inline {{ $i === 0 ? 'text-[#081B28]' : 'text-gray-400' }}">{{ $paso }}</span>
                    </span>
                    @unless ($loop->last)
                        <span class="mx-3 h-0.5 flex-1 rounded-full bg-gray-100">
                            <span data-linea="{{ $i }}" class="block h-full w-0 rounded-full bg-[#39A900] transition-all duration-300"></span>
                        </span>
                    @endunless
                </li>
            @endforeach
        </ol>

        <div class="mt-8">
            @include('Includes.mensajes')
        </div>

        <form action="{{ route('registro.post') }}" method="POST" enctype="multipart/form-data" id="formRegistro">
            @csrf

            {{-- Paso 1: rol --}}
            <fieldset data-paso="0">
                <legend class="text-base font-bold text-[#081B28]">¿Cómo te vas a registrar?</legend>
                <p class="mt-1 text-sm text-slate-500">Elige el rol que te describe.</p>
                <div class="mt-5 space-y-3">
                    @foreach ([
                        'aspirante' => ['Aspirante', 'fa-user-clock', 'Quiero inscribirme a una oferta de formación.'],
                        'aprendiz' => ['Aprendiz', 'fa-user-graduate', 'Ya estudio en un programa del SENA.'],
                        'instructor' => ['Instructor', 'fa-chalkboard-user', 'Oriento formación en un centro del SENA.'],
                    ] as $valor => [$texto, $icono, $ayuda])
                        <label class="group flex cursor-pointer items-center gap-4 rounded-2xl border-2 border-gray-200 p-4 transition hover:border-gray-300 has-[:checked]:border-[#39A900] has-[:checked]:bg-[#E8F7DF]/50">
                            <input type="radio" name="rol" value="{{ $valor }}" class="peer sr-only" @checked(old('rol', 'aspirante') === $valor)>
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-lg text-gray-500 transition peer-checked:bg-[#39A900] peer-checked:text-white">
                                <i class="fa-solid {{ $icono }}"></i>
                            </span>
                            <span class="flex-1">
                                <span class="block font-bold text-[#081B28]">{{ $texto }}</span>
                                <span class="block text-sm text-slate-500">{{ $ayuda }}</span>
                            </span>
                            <span class="flex h-6 w-6 items-center justify-center rounded-full border-2 border-gray-300 text-[10px] text-transparent transition peer-checked:border-[#39A900] peer-checked:bg-[#39A900] peer-checked:text-white">
                                <i class="fa-solid fa-check"></i>
                            </span>
                        </label>
                    @endforeach
                </div>
            </fieldset>

            {{-- Paso 2: datos personales --}}
            <fieldset data-paso="1" class="hidden">
                <legend class="text-base font-bold text-[#081B28]">Tus datos personales</legend>
                <p class="mt-1 text-sm text-slate-500">Escríbelos como aparecen en tu documento.</p>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    @foreach (['nombre_1' => ['Primer nombre', true], 'nombre_2' => ['Segundo nombre', false], 'apellido_1' => ['Primer apellido', true], 'apellido_2' => ['Segundo apellido', false]] as $campo => [$texto, $obligatorio])
                        <div>
                            <label for="{{ $campo }}" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ $texto }}
                                @if ($obligatorio)<span class="text-red-500">*</span>@else<span class="font-normal text-gray-400">(opcional)</span>@endif
                            </label>
                            <input type="text" id="{{ $campo }}" name="{{ $campo }}" value="{{ old($campo) }}" maxlength="20"
                                pattern="[A-Za-z]+" title="Solo letras, sin tildes ni espacios" class="{{ $claseCampo }}" {{ $obligatorio ? 'required' : '' }}>
                        </div>
                    @endforeach
                </div>
                <p class="mt-3 flex items-start gap-2 rounded-xl bg-amber-50 p-3 text-xs text-amber-700">
                    <i class="fa-solid fa-circle-info mt-0.5"></i>
                    Usa solo letras, sin tildes, sin ñ y sin espacios en cada campo.
                </p>

                <div class="mt-5 grid gap-4 sm:grid-cols-[1fr_1.4fr]">
                    <div>
                        <label for="tipo_identificacion" class="mb-2 block text-sm font-semibold text-gray-700">Tipo de documento <span class="text-red-500">*</span></label>
                        <select id="tipo_identificacion" name="tipo_identificacion" required class="{{ $claseCampo }}">
                            @foreach (['CC' => 'Cédula de ciudadanía', 'TI' => 'Tarjeta de identidad', 'CE' => 'Cédula de extranjería', 'PPT' => 'Permiso por protección temporal'] as $valor => $texto)
                                <option value="{{ $valor }}" @selected(old('tipo_identificacion', 'CC') === $valor)>{{ $texto }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="identificacion" class="mb-2 block text-sm font-semibold text-gray-700">Número de documento <span class="text-red-500">*</span></label>
                        <input type="text" id="identificacion" name="identificacion" value="{{ old('identificacion') }}" required inputmode="numeric"
                            placeholder="1061234567" class="{{ $claseCampo }}">
                    </div>
                </div>
            </fieldset>

            {{-- Paso 3: acceso --}}
            <fieldset data-paso="2" class="hidden">
                <legend class="text-base font-bold text-[#081B28]">Tu acceso a la plataforma</legend>
                <p class="mt-1 text-sm text-slate-500">Con este correo y contraseña iniciarás sesión.</p>

                {{-- Resumen de lo que ya escribió --}}
                <div class="mt-5 flex items-center gap-4 rounded-2xl bg-[#081B28] p-4 text-white">
                    <span id="resumenIniciales" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#39A900] text-sm font-extrabold"></span>
                    <span class="min-w-0 flex-1">
                        <span id="resumenNombre" class="block truncate font-bold"></span>
                        <span id="resumenDocumento" class="block text-xs text-slate-400"></span>
                    </span>
                    <span id="resumenRol" class="rounded-full bg-white/10 px-3 py-1 text-xs font-bold capitalize text-[#90EE90]"></span>
                </div>

                <div class="mt-5 space-y-4">
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">Correo electrónico <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fa-regular fa-envelope pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                placeholder="nombre@correo.com" class="{{ $claseCampo }} pl-11">
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach (['password' => 'Contraseña', 'password_confirmation' => 'Repite la contraseña'] as $campo => $texto)
                            <div>
                                <label for="{{ $campo }}" class="mb-2 block text-sm font-semibold text-gray-700">{{ $texto }} <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="password" id="{{ $campo }}" name="{{ $campo }}" required maxlength="8" autocomplete="new-password"
                                        class="{{ $claseCampo }} pr-12">
                                    <button type="button" data-ver-clave="{{ $campo }}" aria-label="Mostrar contraseña"
                                        class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-gray-400 hover:text-[#081B28]">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- Fortaleza de la contraseña y coincidencia --}}
                    <div class="rounded-xl bg-gray-50 p-3">
                        <div class="flex gap-1.5">
                            @for ($i = 0; $i < 4; $i++)
                                <span data-barra-clave class="h-1.5 flex-1 rounded-full bg-gray-200 transition"></span>
                            @endfor
                        </div>
                        <div class="mt-2 flex items-center justify-between text-xs">
                            <span id="textoClave" class="text-gray-400">Hasta 8 caracteres. Combina letras y números.</span>
                            <span id="coincideClave" class="hidden font-semibold"></span>
                        </div>
                    </div>

                    {{-- Foto con vista previa --}}
                    <div>
                        <span class="mb-2 block text-sm font-semibold text-gray-700">Foto de perfil <span class="font-normal text-gray-400">(opcional)</span></span>
                        <label for="foto_perfil" class="flex cursor-pointer items-center gap-4 rounded-2xl border-2 border-dashed border-gray-300 p-4 transition hover:border-[#39A900] hover:bg-[#E8F7DF]/30">
                            <span class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gray-100 text-xl text-gray-400">
                                <img id="vistaFoto" alt="" class="hidden h-full w-full object-cover">
                                <i id="iconoFoto" class="fa-solid fa-camera"></i>
                            </span>
                            <span>
                                <span class="block text-sm font-bold text-[#081B28]">Sube una foto</span>
                                <span class="block text-xs text-slate-500">Formato PNG, máximo 2 MB.</span>
                            </span>
                            <input type="file" id="foto_perfil" name="foto_perfil" accept=".png" class="sr-only">
                        </label>
                    </div>
                </div>
            </fieldset>

            {{-- Navegación entre pasos --}}
            <div class="mt-8 flex items-center gap-3 border-t border-gray-100 pt-6">
                <button type="button" id="btnAtras"
                    class="hidden items-center gap-2 rounded-xl border border-gray-300 px-5 py-3.5 text-sm font-bold text-gray-700 transition hover:bg-gray-50">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Atrás
                </button>
                <button type="button" id="btnSiguiente"
                    class="ml-auto inline-flex items-center gap-2 rounded-xl bg-[#081B28] px-6 py-3.5 text-sm font-bold text-white transition hover:bg-[#123247]">
                    Continuar <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
                <button type="submit" id="btnCrear" data-cargando="Creando tu cuenta..."
                    class="ml-auto hidden items-center gap-2 rounded-xl bg-[#39A900] px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-[#39A900]/25 transition hover:bg-[#2e8800]">
                    <i class="fa-solid fa-user-plus"></i> Crear mi cuenta
                </button>
            </div>
        </form>

        <p class="mt-8 text-center text-sm text-slate-500">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="font-bold text-[#278000] hover:underline">Inicia sesión</a>
        </p>
    </div>
@endsection

@include('Auth._ver-clave')

@push('scripts')
    <script>
        // Registro en tres pasos: valida cada paso antes de avanzar
        (function() {
            const pasos = Array.from(document.querySelectorAll('[data-paso]'));
            const atras = document.getElementById('btnAtras');
            const siguiente = document.getElementById('btnSiguiente');
            const crear = document.getElementById('btnCrear');
            let actual = 0;

            function mostrar(indice) {
                actual = indice;
                pasos.forEach((paso, i) => paso.classList.toggle('hidden', i !== indice));
                atras.classList.toggle('hidden', indice === 0);
                atras.classList.toggle('inline-flex', indice !== 0);
                siguiente.classList.toggle('hidden', indice === pasos.length - 1);
                crear.classList.toggle('hidden', indice !== pasos.length - 1);
                crear.classList.toggle('inline-flex', indice === pasos.length - 1);

                document.querySelectorAll('[data-punto]').forEach(function(punto) {
                    const i = Number(punto.dataset.punto);
                    punto.className = 'flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold transition ' +
                        (i < indice ? 'bg-[#E8F7DF] text-[#278000]' : i === indice ? 'bg-[#39A900] text-white shadow-lg shadow-[#39A900]/30' : 'bg-gray-100 text-gray-400');
                    punto.innerHTML = i < indice ? '<i class="fa-solid fa-check text-xs"></i>' : String(i + 1);
                });
                document.querySelectorAll('[data-nombre]').forEach(function(nombre) {
                    const i = Number(nombre.dataset.nombre);
                    nombre.classList.toggle('text-[#081B28]', i <= indice);
                    nombre.classList.toggle('text-gray-400', i > indice);
                });
                document.querySelectorAll('[data-linea]').forEach(function(linea) {
                    linea.style.width = Number(linea.dataset.linea) < indice ? '100%' : '0';
                });
            }

            function pasoValido() {
                const campos = pasos[actual].querySelectorAll('input, select');
                for (const campo of campos) {
                    if (!campo.checkValidity()) {
                        campo.reportValidity();
                        return false;
                    }
                }
                return true;
            }

            function resumen() {
                const valor = id => (document.getElementById(id).value || '').trim();
                const nombre = [valor('nombre_1'), valor('nombre_2'), valor('apellido_1'), valor('apellido_2')].filter(Boolean).join(' ');
                document.getElementById('resumenNombre').textContent = nombre;
                document.getElementById('resumenIniciales').textContent = (valor('nombre_1').charAt(0) + valor('apellido_1').charAt(0)).toUpperCase();
                document.getElementById('resumenDocumento').textContent = valor('tipo_identificacion') + ' ' + valor('identificacion');
                const rol = document.querySelector('input[name="rol"]:checked');
                document.getElementById('resumenRol').textContent = rol ? rol.value : '';
            }

            siguiente.addEventListener('click', () => {
                if (!pasoValido()) return;
                mostrar(actual + 1);
                if (actual === pasos.length - 1) resumen();
            });

            // Fortaleza de la contraseña
            const clave = document.getElementById('password');
            const confirmar = document.getElementById('password_confirmation');
            function revisarClave() {
                const v = clave.value;
                let puntos = 0;
                if (v.length >= 6) puntos++;
                if (/[A-Z]/.test(v) && /[a-z]/.test(v)) puntos++;
                if (/\d/.test(v)) puntos++;
                if (/[^A-Za-z0-9]/.test(v)) puntos++;
                const colores = ['bg-red-400', 'bg-amber-400', 'bg-lime-500', 'bg-[#39A900]'];
                const textos = ['Muy débil', 'Débil', 'Buena', 'Muy segura'];
                document.querySelectorAll('[data-barra-clave]').forEach(function(barra, i) {
                    barra.className = 'h-1.5 flex-1 rounded-full transition ' + (v && i < Math.max(puntos, 1) ? colores[Math.max(puntos, 1) - 1] : 'bg-gray-200');
                });
                const texto = document.getElementById('textoClave');
                texto.textContent = v ? textos[Math.max(puntos, 1) - 1] : 'Hasta 8 caracteres. Combina letras y números.';
                texto.className = v ? 'font-semibold text-gray-600' : 'text-gray-400';

                const coincide = document.getElementById('coincideClave');
                if (confirmar.value) {
                    const ok = confirmar.value === v;
                    coincide.classList.remove('hidden');
                    coincide.className = 'font-semibold ' + (ok ? 'text-[#278000]' : 'text-red-500');
                    coincide.innerHTML = ok ? '<i class="fa-solid fa-check"></i> Coinciden' : '<i class="fa-solid fa-xmark"></i> No coinciden';
                } else {
                    coincide.classList.add('hidden');
                }
            }
            clave.addEventListener('input', revisarClave);
            confirmar.addEventListener('input', revisarClave);
            atras.addEventListener('click', () => mostrar(actual - 1));

            // Vista previa de la foto
            document.getElementById('foto_perfil').addEventListener('change', function() {
                const archivo = this.files[0];
                if (!archivo) return;
                const vista = document.getElementById('vistaFoto');
                vista.src = URL.createObjectURL(archivo);
                vista.classList.remove('hidden');
                document.getElementById('iconoFoto').classList.add('hidden');
            });

            mostrar(0);
        })();
    </script>
@endpush
