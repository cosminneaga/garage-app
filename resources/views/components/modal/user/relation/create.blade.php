@props([
    'resource',
    'id' => 'create-user',
    'countries' => [],
    'trigger' => true,
    'trigger_label' => 'Create User',
    'title' => 'Create & Attach an user',
])

@php
    $parentName = $resource->getTable();
    $ids = (object) [
        'modal' => $parentName . '-' . $id . '-modal',
        'trigger' => $parentName . '-' . $id . '-modal-trigger',
        'submit' => $parentName . '-' . $id . '-modal-submit-resource',
    ];
@endphp

@if ($trigger)
    <x-button
        class="w-fit"
        id="{{ $ids->trigger }}"
        data-test="{{ $ids->trigger }}"
        data-modal-target="{{ $ids->modal }}"
        data-modal-toggle="{{ $ids->modal }}"
        type="button"
        variant="secondary"
    >{{ $trigger_label }}</x-button>
@endif

<x-modal.wrapper
    id="{{ $ids->modal }}"
    title="{{ $title }}"
    size="7xl"
>

    <form
        id="company-user-create-form"
        action="{{ route('users.' . $parentName . '.store', $resource) }}"
        method="POST"
        enctype="@enctype"
    >
        @csrf

        <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">
            <div class="p-2">
                <x-form.content.user
                    identifier="user_create"
                    :exclude="['role']"
                />
            </div>

            <div class="p-2">
                <x-form.content.address
                    :countries="$countries"
                    identifier="user_create"
                    nestedParentName="address"
                />
            </div>

            <div class="p-2">
                <x-form.content.contact
                    identifier="user_create"
                    nestedParentName="contact"
                />
            </div>
        </div>

        <div class="flex gap-1">
            <x-button
                id="{{ $ids->submit }}"
                form="company-user-create-form"
                type="submit"
            >Submit</x-button>
        </div>
    </form>
</x-modal.wrapper>
