{{-- Botones al final de un formulario. Parámetros: cancelar, texto --}}
<div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
    <a href="{{ $cancelar }}" class="btn-secundario">Cancelar</a>
    <button type="submit" class="btn-primario">
        <i class="fa-solid fa-floppy-disk"></i>
        {{ $texto ?? 'Guardar' }}
    </button>
</div>
