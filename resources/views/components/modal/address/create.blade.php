@props(['id', 'resource', 'trigger' => false, 'triggerId' => ''])

@php
    use App\Models\Country;

    $routeName = $resource->getTable();
@endphp

@if ($trigger)
    <x-button
        class="w-fit"
        data-modal-target="{{ $id }}"
        data-modal-toggle="{{ $id }}"
        type="button"
        :id="$triggerId"
        variant="default"
    >Add Address</x-button>
@endif

<x-modal.wrapper :id="$id">
    <form
        action="{{ route($routeName . '.address.store', $resource) }}"
        method="POST"
    >
        @csrf

        <x-form.field
            name="number"
            type="text"
            label="Number"
            value="234B"
        />
        <x-form.field
            name="street"
            type="text"
            label="Street"
            value="SunFlower Street"
        />
        <x-form.field
            name="postcode"
            type="text"
            label="Postcode"
            value="227364"
        />
        <x-form.field
            name="country_id"
            type="select"
            label="Select a country"
            select_map_label="name"
            select_map_value="id"
            :options="Country::all()"
            selected_value="1"
        />
        <h3 class="text-lg font-bold">Location</h3>
        <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">
        <x-form.field
            name="coordinates[latitude]"
            type="text"
            label="Latitude"
            value="8.327832"
        />
        <x-form.field
            name="coordinates[longitude]"
            type="text"
            label="Longitude"
            value="94.676743"
        />

        <x-form.field
            name="extra"
            type="textarea"
            label="Extra Information"
            value="Suite 75488, to the left of the building"
        />

        <div class="flex gap-1">
            <x-button data-test="form-address-create-submit">Submit</x-button>
        </div>
    </form>
</x-modal.wrapper>
