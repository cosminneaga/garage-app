@props([
    'id',
    'resource',
    'action' => '#',
    'trigger' => false,
    'makes' => [],
    'models' => [],
    'data' => [],
    'years' => [],
])

@php
    $ids = [
        'modal' => $id . '_modal',
        'trigger' => $id . '_trigger',
        'submit' => $id . '_submit',
        'form' => $id . '_form',
    ];
@endphp

@if ($trigger)
    <x-button
        id="{{ $ids['trigger'] }}"
        data-modal-target="{{ $ids['modal'] }}"
        data-modal-toggle="{{ $ids['modal'] }}"
        type="button"
    >
        Create
    </x-button>
@endif
<div>

    <x-modal.wrapper
        title="Create new vehicle"
        id="{{ $ids['modal'] }}"
        size="7xl"
    >
        <form
            action="{{ $action }}"
            method="POST"
            id="{{ $ids['form'] }}"
            x-ref="{{ $ids['form'] }}"
        >
            @csrf

            <x-form.content.vehicle
                identifier="vehicle"
                :makes="$makes"
                :models="$models"
                :data="$data"
                :years="$years"
            />

            <x-button
                id="{{ $ids['submit'] }}"
                type="submit"
            >Submit</x-button>
        </form>
    </x-modal.wrapper>
</div>
