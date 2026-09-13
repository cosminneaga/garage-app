@props(['id', 'parent', 'action' => '#', 'trigger' => false, 'countries' => []])

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
        Add client
    </x-button>
@endif

<x-modal.wrapper
    id="{{ $ids['modal'] }}"
    title="Create new client"
    size="7xl"
>
    <form
        id="{{ $ids['form'] }}"
        action="{{ $action }}"
        method="POST"
        x-ref="{{ $ids['form'] }}"
    >
        @csrf

        <div class="grid grid-rows-1 gap-4 md:grid-cols-3">
            <x-form.content.client
                identifier="client"
                :countries="$countries"
            />

            <x-form.content.address
                identifier="client"
                :countries="$countries"
                nested_parent_name="address"
            />

            <x-form.content.contact
                identifier="client"
                nested_parent_name="contact"
            />
        </div>

        <x-button
            id="{{ $ids['submit'] }}"
            type="submit"
        >Submit</x-button>
    </form>
</x-modal.wrapper>
