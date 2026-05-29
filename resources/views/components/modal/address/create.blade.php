@props(['id', 'resource', 'countries', 'trigger' => false])

@php
    $parentname = $resource->getTable();
    $ids = [
        'modal' => $parentname . '-' . $id . '-modal',
        'trigger' => $parentname . '-' . $id . '-modal-trigger',
        'submit' => $parentname . '-' . $id . '-modal-submit',
    ];
@endphp

@if ($trigger)
    <x-button
        class="w-fit"
        id="{{ $ids['trigger'] }}"
        data-modal-target="{{ $ids['modal'] }}"
        data-modal-toggle="{{ $ids['modal'] }}"
        type="button"
        variant="default"
    >Add Address</x-button>
@endif

<x-modal.wrapper id="{{ $ids['modal'] }}">
    <form
        action="{{ route($parentname . '.address.store', $resource) }}"
        method="POST"
    >
        @csrf

        <x-form.field
            name="number"
            type="text"
            label="Number"
            test_identifier="address"
        />
        <x-form.field
            name="street"
            type="text"
            label="Street"
            test_identifier="address"
        />
        <x-form.field
            name="postcode"
            type="text"
            label="Postcode"
            test_identifier="address"
        />
        <x-form.field
            name="country_id"
            type="select"
            label="Select a country"
            select_map_label="name"
            select_map_value="id"
            :options="$countries"
            selected_value="1"
            test_identifier="address"
        />
        <h3 class="text-lg font-bold">Location</h3>
        <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">
        <x-form.field
            name="coordinates[latitude]"
            type="text"
            label="Latitude"
            test_identifier="address"
        />
        <x-form.field
            name="coordinates[longitude]"
            type="text"
            label="Longitude"
            test_identifier="address"
        />

        <x-form.field
            name="extra"
            type="textarea"
            label="Extra Information"
            test_identifier="address"
        />

        <div class="flex gap-1">
            <x-button id="{{ $ids['submit'] }}" type="submit">Submit</x-button>
        </div>
    </form>
</x-modal.wrapper>
