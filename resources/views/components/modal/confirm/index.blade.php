@props([
    'id' => null,
    'action' => null,
    'message' => 'Please confirm this action!',
    'trigger' => false,
    'type' => 'delete',
])

@php
    $ids = [
        'modal' => $id . '-modal',
        'trigger' => $id . '-modal-trigger',
        'confirm' => $id . '-modal-confirm',
    ];

    switch ($type) {
        case 'delete':
            $label = [
                'trigger' => 'Delete',
                'confirm' => 'Yes, I\'m sure',
                'cancel' => 'No, cancel',
            ];
            $class = [
                'trigger' => 'danger',
                'confirm' => 'danger',
            ];
            break;

        case 'restore':
            $label = [
                'trigger' => 'Restore',
                'confirm' => 'Yes, I\'m sure',
                'cancel' => 'No, cancel',
            ];
            $class = [
                'trigger' => 'default',
                'confirm' => 'default',
            ];
            break;

        default:
            $label = [
                'trigger' => 'Action',
                'confirm' => 'Yes, I\'m sure',
                'cancel' => 'No, cancel',
            ];
            $class = [
                'trigger' => 'success',
                'confirm' =>
                    'bg-success hover:bg-success-strong focus:ring-success-medium',
            ];
            break;
    }
@endphp

@if ($trigger)
    <x-button
        id="{{ $ids['trigger'] }}"
        data-modal-target="{{ $ids['modal'] }}"
        data-modal-toggle="{{ $ids['modal'] }}"
        type="button"
        :variant="$class['trigger']"
    >{{ $label['trigger'] }}</x-button>
@endif

<x-modal.wrapper
    id="{{ $ids['modal'] }}"
    position="center"
>
    <x-fwb-o-info-circle class="text-fg-disabled mx-auto mb-4 h-12 w-12" />
    <h3 class="text-body mb-6">{{ $message }}</h3>
    <div class="flex items-center justify-center space-x-4">

        <form
            action="{{ $action }}"
            method="POST"
        >
            @csrf
            @if ($type === 'delete')
                @method ('DELETE')
            @endif

            <x-button
                id="{{ $ids['confirm'] }}"
                data-modal-hide="{{ $ids['modal'] }}"
                type="submit"
                :variant="$class['confirm']"
            >{{ $label['confirm'] }}</x-button>
        </form>

        <button
            class="text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-neutral-tertiary shadow-xs rounded-base box-border border px-4 py-2.5 text-sm font-medium leading-5 focus:outline-none focus:ring-4"
            data-modal-hide="{{ $ids['modal'] }}"
            type="button"
        >
            {{ $label['cancel'] }}
        </button>

    </div>
</x-modal.wrapper>
