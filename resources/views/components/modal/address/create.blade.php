@props(['id', 'action' => '#', 'trigger' => false, 'countries' => []])

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
        Add Address
    </x-button>
@endif

<x-modal.wrapper
    id="{{ $ids->get('modal') }}"
    title="Create new address"
    size="6xl"
>
    <form
        id="{{ $ids->get('form') }}"
        action="{{ $action }}"
        method="POST"
    >
        @csrf

        <div class="grid grid-rows-1 gap-4 md:grid-cols-3">
            <x-form.content.address
                identifier="address"
                :countries="$countries"
            />
        </div>

        <br>
        <x-button
            id="{{ $ids->get('submit') }}"
            type="submit"
        >Submit</x-button>
    </form>
</x-modal.wrapper>
