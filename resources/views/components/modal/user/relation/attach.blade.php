@props([
    'resource',
    'id' => 'attach-user',
    'countries' => [],
    'existing_users' => [],
    'trigger' => true,
    'trigger_label' => 'Attach User',
])

@php
    $parentname = $resource->getTable();
    $ids = (object) [
        'modal' => $parentname . '-' . $id . '-modal',
        'trigger' => $parentname . '-' . $id . '-modal-trigger',
        'submit_attach' => $parentname . '-' . $id . '-modal-submit-attach',
    ];
@endphp

@if ($trigger)
    <x-button
        class="w-fit"
        id="{{ $ids->trigger }}"
        data-modal-target="{{ $ids->modal }}"
        data-modal-toggle="{{ $ids->modal }}"
        type="button"
        variant="secondary"
    >{{ $trigger_label }}</x-button>
@endif

<x-modal.wrapper
    id="{{ $ids->modal }}"
    title="Attach an existing user"
    size="7xl"
>
    <x-table.users
        :data="$existing_users"
        :parent_resource="$resource"
        routes_prefix="companies"
        attach
    />
</x-modal.wrapper>
