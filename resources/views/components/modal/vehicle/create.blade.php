@props(['id', 'action' => '#', 'trigger' => false])

@php
    $ids = BladeModalHelper::ids($id);
@endphp

@if ($trigger)
    <x-button
        id="{{ $ids->get('trigger') }}"
        data-modal-target="{{ $ids->get('modal') }}"
        data-modal-toggle="{{ $ids->get('modal') }}"
        type="button"
    >
        Add vehicle
    </x-button>
@endif

<div>

    <x-modal.wrapper
        id="{{ $ids->get('modal') }}"
        title="Create new vehicle"
        size="7xl"
    >
        <form
            id="{{ $ids->get('form') }}"
            x-ref="{{ $ids->get('form') }}"
            action="{{ $action }}"
            method="POST"
        >
            @csrf

            <div class="grid grid-rows-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <x-form.content.vehicle identifier="vehicle" />
            </div>

            <br>
            <x-button
                id="{{ $ids->get('submit') }}"
                type="submit"
            >Submit</x-button>
        </form>
    </x-modal.wrapper>
</div>
