@props([
    'title' => null,
    'message' => null,
    'type' => 'success',
    'timeout' => 3000,
    'id' => 'alert',
    'message_list' => [],
])

@php
    switch ($type) {
        case 'info':
            $class = 'text-fg-brand-strong bg-brand-soft border-brand-subtle';
            break;
        case 'error':
            $class =
                'text-fg-danger-strong bg-danger-soft border-danger-subtle';
            break;
        case 'warning':
            $class =
                'text-fg-warning-strong bg-warning-soft border-warning-subtle';
            break;
        case 'success':
            $class =
                'text-fg-success-strong bg-success-soft border-success-subtle';
            break;
        default:
            $class =
                'text-fg-success-strong bg-success-soft border-success-subtle';
            break;
    }
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, {{ $timeout }})"
    x-transition.opacity.duration.300ms
>
    <div
        class="{{ $class }} rounded-base relative mb-4 grid auto-cols-max grid-flow-col items-center border p-4 text-sm"
        id="{{ $id }}"
        role="alert"
    >
        <div class="w-16">
            <x-fwb-o-bell-active-alt class="h-8 w-8" />
        </div>

        <div class="mr-6">
            <span class="sr-only">Info</span>
            <div>
                <p class="text-lg">{{ $title }}</p>
                @if (count($message_list))
                    <ul class="mt-2 list-outside list-disc space-y-1 ps-2.5">
                        @foreach ($message_list as $msg)
                            <li>{{ $msg }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>{{ $message }}</p>
                @endif
            </div>
        </div>

        <button
            class="bg-danger-medium focus:ring-danger-soft hover:bg-danger-soft absolute right-2 top-2 h-6 w-6 rounded p-1.5 text-white"
            data-dismiss-target="#{{ $id }}"
            type="button"
            aria-label="Close"
        >
            <span class="sr-only">Close</span>
            <x-fwb-o-close />
        </button>
    </div>
</div>
