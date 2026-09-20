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
        Add client
    </x-button>
@endif

<x-modal.wrapper
    id="{{ $ids->get('modal') }}"
    title="Create new client"
    size="7xl"
>
    <form
        id="{{ $ids->get('form') }}"
        action="{{ $action }}"
        method="POST"
    >
        @csrf

        <br>
        <div class="grid grid-rows-1 gap-4 md:grid-cols-3">
            <x-form.content.client
                identifier="modal_client"
                :countries="$countries"
            />

            <x-form.content.address
                identifier="modal_client"
                :countries="$countries"
                nested_parent_name="address"
            />

            <x-form.content.contact
                identifier="modal_client"
                nested_parent_name="contact"
            />
        </div>

        <br>
        <x-button
            id="{{ $ids->get('submit') }}"
            form_id="{{ $ids->get('form') }}"
            type="submit"
        >Submit</x-button>
    </form>
</x-modal.wrapper>
