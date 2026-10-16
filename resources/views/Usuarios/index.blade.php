@extends('Layouts.Admin')

@section('title', 'Usuarios')

@section('contenido')
    @php
        // Normaliza la respuesta de la API (lista directa o paginada)
        if (is_object($usuarios) && property_exists($usuarios, 'data')) {
            $usuarios = (array) $usuarios->data;
        } elseif (is_array($usuarios) && isset($usuarios['data']) && is_array($usuarios['data'])) {
            $usuarios = $usuarios['data'];
        } elseif (!is_array($usuarios)) {
            $usuarios = [];
        }
        $get = function ($item, $keys, $default = null) {
            foreach ((array) $keys as $key) {
                $value = data_get($item, $key);
                if ($value !== null && $value !== '') {
                    return $value;
                }
            }
            return $default;
        };
        // Nombre completo: nombre_1 nombre_2 apellido_1 apellido_2
        $nombreDe = function ($u) {
            $partes = array_filter(
                [
                    data_get($u, 'nombre_1'),
                    data_get($u, 'nombre_2'),
                    data_get($u, 'apellido_1'),
                    data_get($u, 'apellido_2'),
                ],
                fn($v) => $v !== null && $v !== '',
            );
            return $partes ? implode(' ', $partes) : 'Usuario sin nombre';
        };
        $inicialesDe = function ($u) {
            $ini =
                mb_strtoupper(mb_substr((string) data_get($u, 'nombre_1', ''), 0, 1, 'UTF-8'), 'UTF-8') .
                mb_strtoupper(mb_substr((string) data_get($u, 'apellido_1', ''), 0, 1, 'UTF-8'), 'UTF-8');
            return $ini ?: 'U';
        };
        $rolDe = fn($u) => (string) $get($u, ['rol'], 'Sin rol');
        // Badge por rol institucional
        $badgeDe = function ($u) use ($rolDe) {
            $rol = strtolower($rolDe($u));
            $estilos = [
                'admin' => ['bg-[#00324d]/10', 'text-[#00324d]', 'ring-[#00324d]/20', 'bg-[#00324d]'],
                'instructor' => ['bg-[#E8F7DF]', 'text-[#278000]', 'ring-[#39A900]/20', 'bg-[#39A900]'],
                'aprendiz' => ['bg-blue-50', 'text-blue-600', 'ring-blue-200', 'bg-blue-500'],
                'aspirante' => ['bg-amber-50', 'text-amber-600', 'ring-amber-200', 'bg-amber-500'],
            ];
            [$chip, $texto, $ring, $punto] = $estilos[$rol] ?? [
                'bg-gray-100',
                'text-gray-500',
                'ring-gray-200',
                'bg-gray-300',
            ];
            return '<span class="inline-flex items-center gap-1.5 rounded-full ' .
                $chip .
                ' px-2.5 py-1 text-[11px] font-bold ' .
                $texto .
                ' ring-1 ' .
                $ring .
                '"><span class="h-1.5 w-1.5 rounded-full ' .
                $punto .
                '"></span>' .
                e($rolDe($u)) .
                '</span>';
        };
        // Detalle según el rol: especialidad (instructor), estado (aprendiz), EPS (aspirante)
        $detalleDe = function ($u) use ($get, $rolDe) {
            $rol = strtolower($rolDe($u));
            if ($rol === 'instructor') {
                $valor = e((string) $get($u, ['teacher.especialidad'], '—'));
                return '<div class="flex items-center gap-2.5 text-gray-600"><i class="fa-solid fa-chalkboard-user text-gray-400"></i><div class="min-w-0"><p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Especialidad</p><p class="truncate text-sm font-medium">' .
                    $valor .
                    '</p></div></div>';
            }
            if ($rol === 'aprendiz') {
                $valor = e((string) $get($u, ['apprentice.estado'], '—'));
                return '<div class="flex items-center gap-2.5 text-gray-600"><i class="fa-solid fa-user-graduate text-gray-400"></i><div class="min-w-0"><p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Estado</p><p class="truncate text-sm font-medium">' .
                    $valor .
                    '</p></div></div>';
            }
            if ($rol === 'aspirante') {
                $valor = e((string) $get($u, ['aspirant.eps'], '—'));
                return '<div class="flex items-center gap-2.5 text-gray-600"><i class="fa-solid fa-heart-pulse text-gray-400"></i><div class="min-w-0"><p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">EPS</p><p class="truncate text-sm font-medium">' .
                    $valor .
                    '</p></div></div>';
            }
            return '<span class="text-gray-400">—</span>';
        };
        $fotoDe = fn($u) => (string) Vista::archivo($get($u, ['foto_perfil'], ''));
        $total = count($usuarios);
        $instructores = count(array_filter($usuarios, fn($u) => strtolower($rolDe($u)) === 'instructor'));
        $aprendices = count(array_filter($usuarios, fn($u) => strtolower($rolDe($u)) === 'aprendiz'));
        $aspirantes = count(array_filter($usuarios, fn($u) => strtolower($rolDe($u)) === 'aspirante'));
    @endphp
    <div class="space-y-6">
        {{-- Encabezado --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                    <i class="fa-solid fa-house"></i>
                    <span>Administración</span>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span class="font-medium text-[#278000]">Usuarios</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Usuarios
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Consulta los usuarios registrados en el sistema.
                </p>
            </div>
            <a href="{{ route('usuarios.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#2e8800] focus:outline-none focus:ring-2 focus:ring-[#39A900] focus:ring-offset-2">
                <i class="fa-solid fa-user-plus"></i>
                Registrar usuario
            </a>
        </div>
        {{-- Mensajes --}}
        @if (session('success'))
            <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                <i class="fa-solid fa-circle-check mt-0.5 text-lg"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                <i class="fa-solid fa-circle-exclamation mt-0.5 text-lg"></i>
                <p>{{ session('error') }}</p>
            </div>
        @endif
        {{-- Resumen --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#E8F7DF] text-[#278000]">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total de usuarios</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $total }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-chalkboard-user text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Instructores</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $instructores }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <i class="fa-solid fa-user-graduate text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Aprendices</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $aprendices }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i class="fa-solid fa-user-plus text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Aspirantes</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $aspirantes }}
                    </p>
                </div>
            </div>
        </div>
        {{-- Tabla --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            {{-- Barra de búsqueda --}}
            <div class="flex flex-col gap-4 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-semibold text-gray-900">
                        Listado de usuarios
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Revisa los datos y las acciones disponibles.
                    </p>
                </div>
                <div class="relative w-full sm:max-w-xs">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="buscarUsuario" type="search" placeholder="Buscar por nombre, email o identificación..."
                        autocomplete="off"
                        class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[860px] text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Usuario</th>
                            <th class="px-6 py-4 font-semibold">Identificación</th>
                            <th class="px-6 py-4 font-semibold">Rol</th>
                            <th class="px-6 py-4 font-semibold">Detalle</th>
                            <th class="px-6 py-4 text-right font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUsuarios" class="divide-y divide-gray-100">
                        @forelse ($usuarios as $usuario)
                            <tr class="fila-usuario transition-colors hover:bg-[#F7F9F6]">

                                {{-- Usuario --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @php $foto = $fotoDe($usuario); @endphp
                                        @if ($foto)
                                            <img src="{{ $foto }}" alt="{{ $nombreDe($usuario) }}"
                                                class="h-11 w-11 shrink-0 rounded-xl object-cover">
                                        @else
                                            <div
                                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#1273a6] to-[#00324d] text-sm font-extrabold text-white shadow-sm">
                                                {{ $inicialesDe($usuario) }}
                                            </div>
                                        @endif

                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900">
                                                {{ $nombreDe($usuario) }}
                                            </p>

                                            <p class="mt-1 truncate text-xs text-gray-400">
                                                {{ $get($usuario, ['email'], 'Sin email') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Identificación --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fa-solid fa-fingerprint text-gray-400"></i>
                                        <span>
                                            {{ $get($usuario, ['tipo_identificacion'], '') }}
                                            {{ $get($usuario, ['identificacion'], 'N/A') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Rol --}}
                                <td class="px-6 py-4">
                                    {!! $badgeDe($usuario) !!}
                                </td>

                                {{-- Detalle --}}
                                <td class="px-6 py-4">
                                    {!! $detalleDe($usuario) !!}
                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('usuarios.show', data_get($usuario, 'id')) }}"
                                            title="Ver detalles" aria-label="Ver detalles"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg text-[#278000] transition hover:bg-[#E8F7DF]">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('usuarios.edit', data_get($usuario, 'id')) }}"
                                            title="Editar usuario" aria-label="Editar usuario"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg text-[#278000] transition hover:bg-[#E8F7DF]">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('usuarios.destroy', data_get($usuario, 'id')) }}" method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Eliminar usuario" aria-label="Eliminar usuario"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-50">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                                        <i class="fa-solid fa-users text-2xl"></i>
                                    </div>

                                    <h3 class="mt-4 font-semibold text-gray-900">
                                        No hay usuarios registrados
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Los usuarios aparecerán aquí cuando se registren en el sistema.
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                        {{-- Resultado de búsqueda vacío --}}
                        <tr id="sinResultados" class="hidden">
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fa-solid fa-magnifying-glass mb-3 block text-2xl text-gray-300"></i>
                                No se encontraron usuarios que coincidan con la búsqueda.
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- Pie de tabla --}}
            @if ($total > 0)
                <div
                    class="flex flex-col gap-2 border-t border-gray-100 bg-white px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <p id="contadorUsuarios" class="text-xs text-gray-500">
                        Mostrando {{ $total }} usuarios
                    </p>

                    <span class="inline-flex items-center gap-2 text-xs font-medium text-gray-500">
                        <span class="h-2 w-2 rounded-full bg-[#39A900]"></span>
                        Información institucional
                    </span>
                </div>
            @endif

        </div>
    </div>

    {{-- Búsqueda en tiempo real --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buscador = document.getElementById('buscarUsuario');
            const filas = Array.from(document.querySelectorAll('.fila-usuario'));
            const sinResultados = document.getElementById('sinResultados');
            const contador = document.getElementById('contadorUsuarios');

            if (!buscador) return;

            buscador.addEventListener('input', function() {
                const busqueda = this.value.toLowerCase().trim();
                let visibles = 0;

                filas.forEach(function(fila) {
                    const coincide = fila.textContent.toLowerCase().includes(busqueda);

                    fila.style.display = coincide ? '' : 'none';

                    if (coincide) {
                        visibles++;
                    }
                });

                if (sinResultados) {
                    sinResultados.classList.toggle('hidden', visibles > 0 || filas.length === 0);
                }

                if (contador) {
                    contador.textContent = `Mostrando ${visibles} de ${filas.length} usuarios`;
                }
            });
        });
    </script>
@endsection
