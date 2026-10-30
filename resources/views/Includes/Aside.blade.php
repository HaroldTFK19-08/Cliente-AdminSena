@php
    /**
     * Renderiza un elemento del menú lateral.
     */
    $navItem = function (string $href, string $icon, string $label, bool $active = false, bool $chevron = false) {
        $linkClass = $active
            ? 'bg-[#39A900]/15 text-white font-semibold'
            : 'text-slate-300 hover:bg-white/[0.06] hover:text-white';
        $iconClass = $active
            ? 'bg-[#39A900] text-white shadow-md shadow-[#39A900]/20'
            : 'bg-white/[0.05] text-slate-400 group-hover:bg-white/10 group-hover:text-[#90EE90]';
        $indicator = $active
            ? '<span class="absolute left-0 top-1/2 h-6 w-1 -translate-y-1/2 rounded-r-full bg-[#39A900]"></span>'
            : '';
        $trailing = '';
        if ($active) {
            $trailing =
                '<span class="h-1.5 w-1.5 rounded-full bg-[#65D62E] shadow-[0_0_8px_rgba(57,169,0,0.8)]"></span>';
        } elseif ($chevron) {
            $trailing =
                '<i class="fa-solid fa-chevron-right text-[9px] text-slate-500 transition-transform duration-200 group-hover:translate-x-0.5 group-hover:text-slate-300"></i>';
        }
        $aria = $active ? ' aria-current="page"' : '';
        return <<<HTML
            <a href="{$href}"{$aria}
               class="group relative flex min-h-11 items-center gap-3 overflow-hidden rounded-xl px-3 py-2.5 transition-all duration-200 {$linkClass}">
                {$indicator}
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg transition-all duration-200 {$iconClass}">
                    <i class="fa-solid {$icon} text-[14px]" aria-hidden="true"></i>
                </span>
                <span class="min-w-0 flex-1 truncate text-[13px] tracking-[0.01em]">
                    {$label}
                </span>
                <span class="flex shrink-0 items-center justify-center">
                    {$trailing}
                </span>
            </a>
        HTML;
    };
    $activo = fn(string ...$rutas) => collect($rutas)->contains(
        fn($r) => request()->is($r) || request()->is($r . '/*'),
    );
    $usuario = session('usuario');
    $conSesion = (bool) session('api_token');
    $esAdmin = data_get($usuario, 'rol') === 'Admin';
    $nombreUsuario = $usuario ? Vista::nombre($usuario, 'Usuario') : 'Visitante';
    $fotoUsuario = Vista::archivo(data_get($usuario, 'foto_perfil'));

    // Aprendices e instructores se gestionan sin iniciar sesión (igual que en la API)
    $comunidad = [
        [route('instructores.index'), 'fa-chalkboard-user', 'Instructores', $activo('instructores')],
        [route('aprendices.index'), 'fa-user-graduate', 'Aprendices', $activo('aprendices')],
    ];

    // Secciones del menú: [url, icono, texto, activo]
    if ($esAdmin) {
        $secciones = [
            'Principal' => [
                [route('home'), 'fa-house', 'Inicio', request()->is('home')],
                [route('usuarios.index'), 'fa-users', 'Usuarios', $activo('usuarios')],
                ...$comunidad,
                [route('perfiles.index', 'admins'), 'fa-id-card', 'Roles', $activo('perfiles')],
            ],
            'Gestión institucional' => [
                [route('centros.index'), 'fa-building-columns', 'Centros de formación', $activo('centros')],
                [route('areas.index'), 'fa-layer-group', 'Áreas de formación', $activo('areas')],
                [route('programas.index'), 'fa-graduation-cap', 'Programas de formación', $activo('programas')],
                [route('fichas.index'), 'fa-users-rectangle', 'Fichas', $activo('fichas')],
                [route('ambientes.index'), 'fa-door-open', 'Ambientes', $activo('ambientes')],
                [route('equipos.index'), 'fa-laptop', 'Equipos', $activo('equipos')],
                [route('asignaciones.index'), 'fa-hand-holding', 'Asignación de equipos', $activo('asignaciones')],
            ],
            'Formación académica' => [
                [route('competencias.index'), 'fa-book-open', 'Competencias', $activo('competencias')],
                [route('resultados.index'), 'fa-list-check', 'Resultados de aprendizaje', $activo('resultados')],
                [route('calificaciones.index'), 'fa-star-half-stroke', 'Calificaciones', $activo('calificaciones')],
            ],
            'Convocatorias' => [
                [route('ofertas.index'), 'fa-bullhorn', 'Ofertas de formación', $activo('ofertas')],
                [route('inscripciones.index'), 'fa-file-signature', 'Inscripciones', $activo('inscripciones')],
                [route('noticias.index'), 'fa-newspaper', 'Noticias', $activo('noticias')],
            ],
        ];
    } elseif ($conSesion) {
        $secciones = [
            'Principal' => [[route('home'), 'fa-house', 'Inicio', request()->is('home')], ...$comunidad],
            'Sitio' => [
                [route('publico.ofertas'), 'fa-bullhorn', 'Convocatorias', false],
                [route('publico.inicio'), 'fa-globe', 'Sitio público', false],
            ],
        ];
    } else {
        $secciones = [
            'Comunidad SENA' => $comunidad,
            'Sitio' => [
                [route('publico.ofertas'), 'fa-bullhorn', 'Convocatorias', false],
                [route('publico.noticias'), 'fa-newspaper', 'Noticias', false],
                [route('publico.inicio'), 'fa-globe', 'Sitio público', false],
            ],
        ];
    }
@endphp
<aside data-menu
    class="fixed inset-y-0 left-0 z-40 flex h-screen w-72 shrink-0 -translate-x-full flex-col overflow-hidden border-r border-white/[0.06] bg-[#081B28] text-slate-300 shadow-2xl transition-transform duration-300 ease-out motion-reduce:transition-none lg:static lg:z-30 lg:translate-x-0 lg:shadow-xl"
    aria-label="Menú de navegación">
    <button type="button" data-menu-cerrar aria-label="Cerrar menú"
        class="absolute right-3 top-3 z-10 flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-white/10 hover:text-white lg:hidden">
        <i class="fa-solid fa-xmark"></i>
    </button>
    {{-- Fondo decorativo --}}
    <div class="pointer-events-none absolute inset-x-0 top-0 h-52 bg-gradient-to-b from-[#39A900]/[0.07] to-transparent">
    </div>
    <div class="pointer-events-none absolute -right-20 top-24 h-48 w-48 rounded-full bg-[#39A900]/[0.07] blur-3xl"></div>
    {{-- Identidad institucional --}}
    <div class="relative shrink-0 px-5 pb-5 pt-6">
        <a href="{{ $conSesion ? route('home') : route('publico.inicio') }}"
            class="group flex items-center gap-3.5 rounded-2xl p-2 transition-colors hover:bg-white/[0.04]">
            <div
                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-white/10 bg-white/[0.06] p-2 shadow-sm transition-all duration-200 group-hover:border-[#39A900]/40 group-hover:bg-white/[0.09]">
                <img src="{{ asset('logoSena.svg') }}" alt="Logo SENA" class="h-full w-full object-contain">
            </div>
            <div class="min-w-0">
                <h1 class="text-xl font-extrabold tracking-tight text-white">
                    Admin<span class="text-[#39A900]">Sena</span>
                </h1>
                <p class="mt-1 text-[9px] font-semibold uppercase tracking-[0.19em] text-slate-400">
                    Gestión institucional
                </p>
            </div>
        </a>
    </div>
    {{-- Separador --}}
    <div class="mx-5 h-px shrink-0 bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
    {{-- Navegación --}}
    <nav class="min-h-0 flex-1 overflow-y-auto px-4 py-6 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
        aria-label="Menú principal">
        @foreach ($secciones as $titulo => $items)
            <div class="{{ $loop->first ? '' : 'mt-7' }}">
                <div class="mb-3 flex items-center justify-between px-3">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">
                        {{ $titulo }}
                    </p>
                    <span class="h-px w-7 bg-white/10"></span>
                </div>
                <ul class="space-y-1.5">
                    @foreach ($items as [$href, $icono, $texto, $esActivo])
                        <li>
                            {!! $navItem($href, $icono, $texto, $esActivo, !$loop->parent->first) !!}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>
    {{-- Perfil del usuario o acceso para visitantes --}}
    <div class="relative shrink-0 border-t border-white/[0.08] bg-[#061620] p-4">
        @if ($conSesion)
            <div class="flex items-center gap-3 rounded-xl border border-white/[0.08] bg-white/[0.035] p-3">
                <div
                    class="relative flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-[#39A900] to-[#247A16] text-sm font-extrabold text-white shadow-md">
                    @if ($fotoUsuario)
                        <img src="{{ $fotoUsuario }}" alt="Foto de perfil" class="h-full w-full object-cover">
                    @else
                        {{ Vista::iniciales($usuario) }}
                    @endif
                    <span
                        class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full border-2 border-[#061620] bg-[#65D62E]"></span>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-xs font-bold text-white">{{ $nombreUsuario }}</p>
                    <p class="mt-1 truncate text-[11px] text-slate-400">{{ data_get($usuario, 'rol', 'Usuario') }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" data-sin-carga>
                    @csrf
                    <button type="submit" aria-label="Cerrar sesión" title="Cerrar sesión"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-slate-400 transition-all hover:bg-rose-500/10 hover:text-rose-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-500/30">
                        <i class="fa-solid fa-right-from-bracket text-sm" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        @else
            <p class="px-1 text-xs leading-5 text-slate-400">
                Consulta y registra instructores y aprendices sin cuenta. Para administrar el resto, inicia sesión como administrador.
            </p>
            <div class="mt-3 grid grid-cols-2 gap-2">
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/[0.04] px-3 py-2.5 text-xs font-semibold text-white transition hover:bg-white/10">
                    <i class="fa-solid fa-right-to-bracket"></i> Ingresar
                </a>
                <a href="{{ route('registro') }}"
                    class="flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-3 py-2.5 text-xs font-semibold text-white transition hover:bg-[#2e8800]">
                    <i class="fa-solid fa-user-plus"></i> Registrarme
                </a>
            </div>
        @endif
    </div>
</aside>
