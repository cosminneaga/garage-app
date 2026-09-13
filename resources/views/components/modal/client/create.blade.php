@props([
    'id',
    'parent',
    'action' => '#',
    'trigger' => false,
    'countries' => [],
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
        Add client
    </x-button>
@endif

<x-modal.wrapper
    title="Create new client"
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

        <x-form.content.client
            identifier="client"
            :countries="$countries"
        />

        <x-button
            id="{{ $ids['submit'] }}"
            type="submit"
        >Submit</x-button>
    </form>
</x-modal.wrapper>
