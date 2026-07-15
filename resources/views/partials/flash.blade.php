@if (session('success'))
    <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-lg mb-6">
        <x-icon name="circle-check" class="w-4 h-4 mt-0.5 shrink-0" />
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-lg mb-6">
        <x-icon name="triangle-alert" class="w-4 h-4 mt-0.5 shrink-0" />
        <span>{{ session('error') }}</span>
    </div>
@endif
