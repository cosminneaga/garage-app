<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'countries' => [],
    'identifier' => '',
    'nestedParentName' => false,
])

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('street_number', $nestedParentName) }}"
        type="text"
        label="Number"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('street', $nestedParentName) }}"
        type="text"
        label="Street"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('postcode', $nestedParentName) }}"
        type="text"
        label="Postcode"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('country_id', $nestedParentName) }}"
        type="select"
        label="Select a country"
        select_map_label="name"
        select_map_value="id"
        :options="$countries"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Location</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('coordinates[latitude]', $nestedParentName) }}"
        type="text"
        label="Latitude"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('coordinates[longitude]', $nestedParentName) }}"
        type="text"
        label="Longitude"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Extra Information</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('building', $nestedParentName) }}"
        type="text"
        label="Building"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('floor', $nestedParentName) }}"
        type="text"
        label="Floor"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('unit', $nestedParentName) }}"
        type="text"
        label="Unit"
    />
</section>
