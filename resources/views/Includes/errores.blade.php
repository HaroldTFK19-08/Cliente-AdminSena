{{-- Errores de validación (los del formulario o los que devuelve la API) --}}
@if ($errors->any())
    <div role="alert" class="flex gap-3 rounded-2xl border border-red-200 bg-red-50/70 p-4 text-sm text-red-700">
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </span>
        <div class="min-w-0">
            <p class="font-semibold text-red-800">
                {{ $errors->count() === 1 ? 'Hay un dato por corregir' : 'Hay ' . $errors->count() . ' datos por corregir' }}
            </p>
            <ul class="mt-1.5 list-inside list-disc space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
