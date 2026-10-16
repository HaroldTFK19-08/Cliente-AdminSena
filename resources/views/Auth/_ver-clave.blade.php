@push('scripts')
    <script>
        // Botón para mostrar u ocultar la contraseña
        document.querySelectorAll('[data-ver-clave]').forEach(function(boton) {
            boton.addEventListener('click', function() {
                const campo = document.getElementById(this.dataset.verClave);
                const visible = campo.type === 'text';
                campo.type = visible ? 'password' : 'text';
                this.firstElementChild.className = visible ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
            });
        });
    </script>
@endpush
