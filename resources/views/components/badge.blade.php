@props(['color' => 'slate'])

@php
    $colors = [
        'emerald' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
        'amber' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
        'red' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
        'blue' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
        'indigo' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200',
        'purple' => 'bg-purple-50 text-purple-700 ring-1 ring-purple-200',
        'cyan' => 'bg-cyan-50 text-cyan-700 ring-1 ring-cyan-200',
        'orange' => 'bg-orange-50 text-orange-700 ring-1 ring-orange-200',
        'slate' => 'bg-slate-50 text-slate-600 ring-1 ring-slate-200',
    ];
@endphp

<span
    {{ $attributes->merge(['class' => 'inline-flex items-center whitespace-nowrap text-xs font-medium px-2.5 py-0.5 rounded-full ' . ($colors[$color] ?? $colors['slate'])]) }}>{{ $slot }}</span>
