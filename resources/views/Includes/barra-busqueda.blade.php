{{-- Barra superior de una tabla con buscador en tiempo real. Parámetros: titulo, placeholder, total --}}
<div class="flex flex-col gap-4 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="font-semibold text-gray-900">{{ $titulo }}</h2>
        <p class="mt-1 text-sm text-gray-500"><span data-contador>{{ $total ?? 0 }}</span> registros</p>
    </div>

    <div class="relative w-full sm:max-w-xs">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input type="search" data-buscador placeholder="{{ $placeholder ?? 'Buscar...' }}" autocomplete="off"
            class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#39A900] focus:ring-2 focus:ring-[#39A900]/20">
    </div>
</div>

@once
    @push('scripts')
        <script>
            // Filtra las filas [data-fila] de la tarjeta donde está el buscador.
            document.querySelectorAll('[data-buscador]').forEach(function(buscador) {
                const tarjeta = buscador.closest('.tarjeta');
                if (!tarjeta) return;

                const filas = Array.from(tarjeta.querySelectorAll('[data-fila]'));
                const sinResultados = tarjeta.querySelector('[data-sin-resultados]');
                const contador = tarjeta.querySelector('[data-contador]');

                buscador.addEventListener('input', function() {
                    const texto = this.value.toLowerCase().trim();
                    let visibles = 0;

                    filas.forEach(function(fila) {
                        const coincide = fila.textContent.toLowerCase().includes(texto);
                        fila.style.display = coincide ? '' : 'none';
                        if (coincide) visibles++;
                    });

                    if (sinResultados) sinResultados.classList.toggle('hidden', visibles > 0 || filas.length === 0);
                    if (contador) contador.textContent = texto ? `${visibles} de ${filas.length}` : filas.length;
                });
            });
        </script>
    @endpush
@endonce
