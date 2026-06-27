@props([
    'id' => 'btn',
    'variant' => 'default',
])

@php
    switch ($variant) {
        case 'default':
            $class =
                'bg-brand hover:bg-brand-strong text-white focus:ring-brand-medium';
            break;

        case 'secondary':
            $class =
                'text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-neutral-tertiary';
            break;

        case 'tertiary':
            $class =
                'text-body bg-neutral-primary-soft hover:bg-neutral-secondary-medium hover:text-heading focus:ring-neutral-tertiary-soft';
            break;

        case 'success':
            $class =
                'text-white bg-success hover:bg-success-strong focus:ring-success-medium';
            break;

        case 'danger':
            $class =
                'text-white bg-danger hover:bg-danger-strong focus:ring-danger-medium';
            break;

        case 'warning':
            $class =
                'text-white bg-warning hover:bg-warning-strong focus:ring-warning-medium';
            break;

        case 'dark':
            $class =
                'text-white bg-dark hover:bg-dark-strong focus:ring-neutral-tertiary';
            break;

        case 'ghost':
            $class =
                'text-heading bg-transparent hover:bg-neutral-secondary-medium focus:ring-neutral-tertiary';
            break;

        default:
            $class =
                'bg-brand hover:bg-brand-strong text-white focus:ring-brand-medium';
            break;
    }
@endphp

<button
    class="{{ $class }} shadow-xs rounded-base box-border border border-transparent px-4 py-2.5 text-sm font-medium leading-5 hover:cursor-pointer focus:outline-none focus:ring-4"
    data-test="{{ $id }}"
    id="{{ $id }}"
    {{ $attributes }}
>{{ $slot }}
</button>
