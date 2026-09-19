@props([
    'resource',
    'id',
    'trigger' => false,
    'countries' => [],
    'existing_users' => [],
])

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
        Attach user
    </x-button>
@endif

<x-modal.wrapper
    id="{{ $ids->get('modal') }}"
    title="Attach an existing user"
    size="7xl"
>
    <x-table.related.users
        :data="$existing_users"
        :resource="$resource"
        attach
    />
</x-modal.wrapper>
