@props([
    'id',
    'resource',
    'trigger' => false,
    'trigger_label' => 'Add User',
    'countries',
    'team',
])

@php
    $parentname = $resource->getTable();
    $ids = (object) [
        'modal' => $parentname . '-' . $id . '-modal',
        'trigger' => $parentname . '-' . $id . '-modal-trigger',
        'submit' => $parentname . '-' . $id . '-modal-submit-resource',
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
        variant="default"
    >{{ $trigger_label }}</x-button>
@endif

<x-modal.wrapper
    id="{{ $ids->modal }}"
    title="Create or Attach existing user"
    size="7xl"
>
    @if ($team->count())
        <x-table.users
            :data="$team"
            :parentResource="$resource"
            routesPrefix="companies"
            attach
        />
    @endif

    <form
        id="company-user-create-form"
        action="{{ route($parentname . '.user.store', $resource) }}"
        method="POST"
        enctype="@enctype"
    >
        @csrf

        <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">
            <div class="p-2">
                <x-form.content.user identifier="user" />
            </div>

            <div class="p-2">
                <x-form.content.address
                    :countries="$countries"
                    identifier="user"
                    nestedParentName="address"
                />
            </div>

            <div class="p-2">
                <x-form.content.contact
                    identifier="user"
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
