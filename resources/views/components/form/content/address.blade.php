<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'countries' => [],
    'identifier' => '',
    'nested_parent_name' => false,
])

{{-- @dd(old()) --}}

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">

    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('street_number', $nested_parent_name) }}"
        label="Number"
        value="{{ old('street_number', '') }}"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('street', $nested_parent_name) }}"
        label="Street"
        value="{{ old('street', '') }}"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('postcode', $nested_parent_name) }}"
        label="Postcode"
        value="{{ old('postcode', '') }}"
    />
    <x-form.field.select
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('country_id', $nested_parent_name) }}"
        label="Select a country"
        map_label="name"
        map_value="id"
        :options="$countries"
        value="{{ old('country_id', '') }}"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Location</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">

    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('coordinates[latitude]', $nested_parent_name) }}"
        label="Latitude"
        value="{{ old('coordinates.latitude', '') }}"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('coordinates[longitude]', $nested_parent_name) }}"
        label="Longitude"
        value="{{ old('coordinates.longitude', '') }}"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Extra Information</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">

    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('building', $nested_parent_name) }}"
        label="Building"
        value="{{ old('building', '') }}"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('floor', $nested_parent_name) }}"
        label="Floor"
        value="{{ old('floor', '') }}"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('unit', $nested_parent_name) }}"
        label="Unit"
        value="{{ old('unit', '') }}"
    />
</section>
