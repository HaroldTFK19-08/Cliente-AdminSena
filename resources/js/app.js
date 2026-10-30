import './bootstrap';

/*
 * Comportamiento del panel (layout Admin): menú en celulares, avisos,
 * confirmación al eliminar y estado de carga de los formularios.
 * Las páginas públicas y de acceso no tienen data-panel, así que no se tocan.
 */
document.addEventListener('DOMContentLoaded', () => {
    if (!document.body.hasAttribute('data-panel')) return;

    // ---------- Menú lateral en celulares ----------
    const menu = document.querySelector('[data-menu]');
    const fondo = document.querySelector('[data-menu-fondo]');
    const abrir = document.querySelector('[data-menu-abrir]');

    const alternarMenu = (abierto) => {
        if (!menu) return;
        menu.classList.toggle('-translate-x-full', !abierto);
        fondo?.classList.toggle('hidden', !abierto);
        abrir?.setAttribute('aria-expanded', String(abierto));
        if (abierto) menu.querySelector('a, button')?.focus();
    };

    abrir?.addEventListener('click', () => alternarMenu(true));
    fondo?.addEventListener('click', () => alternarMenu(false));
    document.querySelectorAll('[data-menu-cerrar]').forEach((b) => b.addEventListener('click', () => alternarMenu(false)));
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && fondo && !fondo.classList.contains('hidden')) alternarMenu(false);
    });

    // ---------- Avisos (se cierran solos a los 5 s) ----------
    document.querySelectorAll('[data-aviso]').forEach((aviso) => {
        const cerrar = () => {
            aviso.classList.add('saliendo');
            setTimeout(() => aviso.remove(), 250);
        };
        aviso.querySelector('[data-aviso-cerrar]')?.addEventListener('click', cerrar);
        let tiempo = setTimeout(cerrar, 5000);
        // Mientras el puntero está encima, el aviso no se cierra
        aviso.addEventListener('mouseenter', () => clearTimeout(tiempo));
        aviso.addEventListener('mouseleave', () => (tiempo = setTimeout(cerrar, 2000)));
    });

    // ---------- Confirmación antes de eliminar ----------
    const dialogo = document.querySelector('[data-dialogo-confirmar]');
    let formularioPendiente = null;

    document.querySelectorAll('form[data-confirmar]').forEach((formulario) => {
        formulario.addEventListener('submit', (e) => {
            if (formulario.dataset.confirmado === '1') return;
            e.preventDefault();
            if (!dialogo?.showModal) {
                if (window.confirm(formulario.dataset.confirmar)) {
                    formulario.dataset.confirmado = '1';
                    formulario.submit();
                }
                return;
            }
            formularioPendiente = formulario;
            dialogo.querySelector('[data-dialogo-mensaje]').textContent = formulario.dataset.confirmar;
            dialogo.showModal();
            dialogo.querySelector('[data-dialogo-cancelar]').focus();
        });
    });

    dialogo?.querySelector('[data-dialogo-cancelar]').addEventListener('click', () => dialogo.close());
    dialogo?.querySelector('[data-dialogo-aceptar]').addEventListener('click', () => {
        if (!formularioPendiente) return;
        formularioPendiente.dataset.confirmado = '1';
        dialogo.close();
        formularioPendiente.submit();
    });
    // Clic fuera del cuadro = cancelar
    dialogo?.addEventListener('click', (e) => {
        if (e.target === dialogo) dialogo.close();
    });

    // ---------- Botón con estado de carga al guardar ----------
    document.querySelectorAll('form:not([data-confirmar]):not([data-sin-carga])').forEach((formulario) => {
        formulario.addEventListener('submit', () => {
            const boton = formulario.querySelector('button[type="submit"]');
            if (!boton || formulario.method.toLowerCase() === 'get') return;
            setTimeout(() => {
                boton.disabled = true;
                boton.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Guardando...';
            }, 0);
        });
    });

    // ---------- Vista previa de la foto en los formularios ----------
    document.querySelectorAll('input[type="file"][name="foto_perfil"][data-vista-previa]').forEach((entrada) => {
        const imagen = document.getElementById(entrada.dataset.vistaPrevia);
        entrada.addEventListener('change', () => {
            const archivo = entrada.files?.[0];
            if (!archivo || !imagen) return;
            imagen.src = URL.createObjectURL(archivo);
            imagen.classList.remove('hidden');
            imagen.nextElementSibling?.classList.add('hidden');
        });
    });
});
