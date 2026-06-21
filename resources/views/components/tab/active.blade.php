@props(['status'])

@php
    switch ($status) {
        case true:
            $class = 'bg-brand-softer border-brand-subtle text-fg-brand-strong';
            break;
        case false:
            $class =
                'bg-danger-soft border-danger-subtle text-fg-danger-strong';
            break;

        default:
            $class = 'bg-brand-softer border-brand-subtle text-fg-brand-strong';
            break;
    }
@endphp

<span
    class="{{ $class }} rounded-full border px-1.5 py-0.5 text-xs font-medium"
>{{ $status ? 'Active' : 'Inactive' }}</span>
