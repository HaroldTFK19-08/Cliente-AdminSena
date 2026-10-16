@if ($errors->any())
    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <p class="mb-2 flex items-center gap-2 font-semibold">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Revisa los datos del formulario
        </p>
        <ul class="list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
