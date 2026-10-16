{{-- Home para instructores, aprendices y aspirantes (se incluye desde welcome) --}}
@php
    $perfil = $usuarioApi ?: $usuario;
    $ofertas = collect($ofertas ?? [])->filter(fn($o) => data_get($o, 'publicada'))->take(6)->all();
    $rol = data_get($perfil, 'rol', data_get($usuario, 'rol'));
    $foto = Vista::archivo(data_get($perfil, 'foto_perfil'));

    // Datos del perfil según el rol (vienen de /auth/me)
    $datos = match ($rol) {
        'Instructor' => [
            ['Especialidad', data_get($perfil, 'teacher.especialidad'), 'fa-star'],
            ['Tipo de instructor', data_get($perfil, 'teacher.tipo_instructor'), 'fa-briefcase'],
            ['Inicio de contrato', Vista::fecha(data_get($perfil, 'teacher.fecha_inicio'), 'd/m/Y', ''), 'fa-calendar'],
        ],
        'Aprendiz' => [
            ['Estado', data_get($perfil, 'apprentice.estado'), 'fa-circle-check'],
            ['Inicio de formación', Vista::fecha(data_get($perfil, 'apprentice.fecha_inicio'), 'd/m/Y', ''), 'fa-calendar'],
            ['Fin de formación', Vista::fecha(data_get($perfil, 'apprentice.fecha_fin'), 'd/m/Y', ''), 'fa-flag-checkered'],
        ],
        'Aspirante' => [
            ['EPS', data_get($perfil, 'aspirant.eps'), 'fa-notes-medical'],
        ],
        default => [],
    };
    $relacion = ['Instructor' => 'teacher', 'Aprendiz' => 'apprentice', 'Aspirante' => 'aspirant'][$rol] ?? null;
    $perfilCompleto = $relacion && data_get($perfil, $relacion);
    $mensajes = [
        'Instructor' => 'Consulta tu información como instructor y las convocatorias vigentes del SENA.',
        'Aprendiz' => 'Consulta el estado de tu formación y las novedades de tu centro.',
        'Aspirante' => 'Revisa las ofertas de formación abiertas y prepara tu inscripción.',
    ];
@endphp

<div class="space-y-8">
    {{-- Bienvenida --}}
    <section class="relative overflow-hidden rounded-3xl bg-[#081B28] p-6 shadow-lg sm:p-8 lg:p-10">
        <div class="absolute -right-16 -top-20 h-64 w-64 rounded-full bg-[#39A900]/20 blur-3xl"></div>
        <div class="absolute -bottom-20 right-1/3 h-48 w-48 rounded-full bg-[#39A900]/10 blur-3xl"></div>
        <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center">
            <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-[#39A900] to-[#247A16] text-2xl font-extrabold text-white shadow-lg">
                @if ($foto)
                    <img src="{{ $foto }}" alt="Foto de perfil" class="h-full w-full object-cover">
                @else
                    {{ Vista::iniciales($perfil) }}
                @endif
            </div>
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-[#90EE90]">
                    <span class="h-2 w-2 rounded-full bg-[#39A900]"></span>
                    {{ mb_strtoupper($rol ?? 'Usuario') }}
                </span>
                <h1 class="mt-3 text-3xl font-extrabold text-white">Hola, {{ data_get($perfil, 'nombre_1', 'bienvenido') }}</h1>
                <p class="mt-2 max-w-xl text-sm leading-7 text-slate-300">{{ $mensajes[$rol] ?? 'Bienvenido a AdminSena.' }}</p>
            </div>
        </div>
    </section>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Mis datos --}}
        <section class="tarjeta p-6 lg:col-span-1">
            <h2 class="tarjeta-titulo mb-4">Mis datos</h2>
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-slate-500">Nombre completo</dt>
                    <dd class="font-semibold text-tinta">{{ Vista::nombre($perfil) }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Identificación</dt>
                    <dd class="font-semibold text-tinta">{{ data_get($perfil, 'tipo_identificacion') }} {{ data_get($perfil, 'identificacion') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Correo</dt>
                    <dd class="break-all font-semibold text-tinta">{{ data_get($perfil, 'email') }}</dd>
                </div>
                @foreach ($datos as [$etiqueta, $valor, $icono])
                    @if (filled($valor))
                        <div>
                            <dt class="flex items-center gap-1.5 text-slate-500"><i class="fa-solid {{ $icono }} text-sena-700"></i>{{ $etiqueta }}</dt>
                            <dd class="font-semibold text-tinta">{{ $valor }}</dd>
                        </div>
                    @endif
                @endforeach
            </dl>

            @unless ($perfilCompleto)
                <p class="mt-5 rounded-lg border border-oro-500/40 bg-oro-50 p-4 text-xs text-oro-700">
                    <i class="fa-solid fa-circle-info mr-1"></i>
                    Tu perfil de {{ strtolower($rol ?? 'usuario') }} aún no está completo. Un administrador debe registrarlo en el sistema.
                </p>
            @endunless
        </section>

        {{-- Ofertas publicadas --}}
        <section class="tarjeta p-6 lg:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="tarjeta-titulo">Ofertas de formación abiertas</h2>
                <a href="{{ route('publico.inicio') }}#ofertas" class="text-xs font-semibold text-sena-700 hover:underline">Ver sitio público</a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @forelse ($ofertas as $oferta)
                    <article class="rounded-lg border border-linea p-4 transition hover:border-sena-200">
                        <p class="font-semibold text-tinta">{{ data_get($oferta, 'program.nombre', 'Programa') }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ data_get($oferta, 'program.area.trainingcenter.nombre') }}</p>
                        <div class="mt-3 flex flex-wrap gap-2 text-xs">
                            <span class="insignia bg-papel text-slate-600"><i class="fa-solid fa-users"></i>{{ data_get($oferta, 'capacidad') }} cupos</span>
                            <span class="insignia bg-sena-50 text-sena-700"><i class="fa-regular fa-calendar"></i>Cierra {{ Vista::fecha(data_get($oferta, 'fecha_fin_convocatoria')) }}</span>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-slate-500 sm:col-span-2">No hay ofertas publicadas en este momento.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
