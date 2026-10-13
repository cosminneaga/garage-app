@props([
    'type' => 'success'
])

@php
    switch ($type) {
        case 'info':
            $class = 'my-2 p-4 mb-4 text-sm text-fg-brand-strong rounded-base bg-brand-softer';
            break;
        case 'danger':
            $class = 'my-2 p-4 mb-4 text-sm text-fg-danger-strong rounded-base bg-danger-soft';
            break;
        case 'warning':
            $class = 'my-2 p-4 mb-4 text-sm text-fg-warning rounded-base bg-warning-soft';
            break;
        case 'success':
            $class = 'my-2 p-4 mb-4 text-sm text-fg-success-strong rounded-base bg-success-soft';
            break;
        default:
            $class = 'my-2 p-4 text-sm text-heading rounded-base bg-neutral-secondary-medium';
            break;
    }
@endphp

<div class="{{ $class }}" role="alert">
  <div class="font-bold text-sm">
    {{ $slot }}
  </div>
</div>
