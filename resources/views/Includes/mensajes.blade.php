{{-- Avisos de sesión (éxito / error) --}}
@if (session('error'))
    <div role="alert" class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
        <p class="flex-1 font-medium">{{ session('error') }}</p>
    </div>
@endif
@if (session('success'))
    <div role="status" class="mb-5 flex items-start gap-3 rounded-xl border border-[#39A900]/30 bg-[#39A900]/10 p-4 text-sm text-[#1e5a00]">
        <i class="fa-solid fa-circle-check mt-0.5 text-[#39A900]"></i>
        <p class="flex-1 font-medium">{{ session('success') }}</p>
    </div>
@endif
