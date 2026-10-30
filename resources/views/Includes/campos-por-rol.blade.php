{{--
    Muestra solo los campos del rol elegido en los radios name="rol" y desactiva los demás,
    para que el navegador no exija ni envíe campos de otro rol.
    Cada bloque se marca con data-rol-campos="Aprendiz" (o "aprendiz" en el registro).
--}}
@once
    @push('scripts')
        <script>
            (function() {
                const radios = document.querySelectorAll('input[name="rol"]');
                const bloques = document.querySelectorAll('[data-rol-campos]');
                if (!radios.length || !bloques.length) return;

                function actualizar() {
                    const elegido = document.querySelector('input[name="rol"]:checked');
                    const rol = elegido ? elegido.value.toLowerCase() : '';
                    bloques.forEach(function(bloque) {
                        const activo = bloque.dataset.rolCampos.toLowerCase() === rol;
                        bloque.classList.toggle('hidden', !activo);
                        bloque.querySelectorAll('input, select, textarea').forEach(campo => campo.disabled = !activo);
                    });
                    document.querySelectorAll('[data-sin-campos-rol]').forEach(function(aviso) {
                        const hay = Array.from(bloques).some(b => b.dataset.rolCampos.toLowerCase() === rol);
                        aviso.classList.toggle('hidden', hay);
                    });
                }

                radios.forEach(radio => radio.addEventListener('change', actualizar));
                actualizar();
            })();
        </script>
    @endpush
@endonce
