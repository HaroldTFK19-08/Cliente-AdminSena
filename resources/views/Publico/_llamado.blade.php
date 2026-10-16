{{-- Llamado final para crear cuenta --}}
<section class="mx-auto max-w-7xl px-5 py-20 sm:px-8">
    <div class="relative overflow-hidden rounded-[2rem] bg-[#081B28] px-8 py-14 shadow-2xl sm:px-14">
        @include('Publico._fondo')
        <div class="relative flex flex-col items-start justify-between gap-8 lg:flex-row lg:items-center">
            <div class="max-w-xl">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">¿Listo para dar el siguiente paso?</h2>
                <p class="mt-3 text-lg text-slate-300">Crea tu cuenta como aspirante y participa en las convocatorias del SENA.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                @if (session('api_token'))
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-7 py-4 text-sm font-bold text-white shadow-lg shadow-[#39A900]/25 transition hover:-translate-y-0.5 hover:bg-[#2e8800]">
                        <i class="fa-solid fa-gauge-high"></i> Ir a mi panel
                    </a>
                @else
                    <a href="{{ route('registro') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#39A900] px-7 py-4 text-sm font-bold text-white shadow-lg shadow-[#39A900]/25 transition hover:-translate-y-0.5 hover:bg-[#2e8800]">
                        <i class="fa-solid fa-user-plus"></i> Crear cuenta
                    </a>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/15 bg-white/5 px-7 py-4 text-sm font-bold text-white transition hover:bg-white/10">
                        Ya tengo cuenta
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
