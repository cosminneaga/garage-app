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
        value="{{ old('street_number', '') }}"
        label="Number"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('street', $nested_parent_name) }}"
        value="{{ old('street', '') }}"
        label="Street"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('postcode', $nested_parent_name) }}"
        value="{{ old('postcode', '') }}"
        label="Postcode"
    />
    <x-form.field.select
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('country_id', $nested_parent_name) }}"
        value="{{ old('country_id', '') }}"
        label="Select a country"
        map_label="name"
        map_value="id"
        :options="$countries"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Location</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">

    <div class="grid grid-cols-2 gap-2">
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('coordinates[latitude]', $nested_parent_name) }}"
            value="{{ old('coordinates.latitude', '') }}"
            label="Latitude"
        />
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('coordinates[longitude]', $nested_parent_name) }}"
            value="{{ old('coordinates.longitude', '') }}"
            label="Longitude"
        />
    </div>
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Extra Information</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">

    <div class="grid grid-cols-3 gap-2">
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('building', $nested_parent_name) }}"
            value="{{ old('building', '') }}"
            label="Building"
        />
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('floor', $nested_parent_name) }}"
            value="{{ old('floor', '') }}"
            label="Floor"
        />
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('unit', $nested_parent_name) }}"
            value="{{ old('unit', '') }}"
            label="Unit"
        />
    </div>
</section>
