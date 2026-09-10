<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'countries' => [],
    'identifier' => '',
    'nested_parent_name' => false,
])

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('street_number', $nested_parent_name) }}"
        label="Number"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('street', $nested_parent_name) }}"
        label="Street"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('postcode', $nested_parent_name) }}"
        label="Postcode"
    />
    <x-form.field.select
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('country_id', $nested_parent_name) }}"
        label="Select a country"
        select_map_label="name"
        select_map_value="id"
        :options="$countries"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Location</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('coordinates[latitude]', $nested_parent_name) }}"
        label="Latitude"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('coordinates[longitude]', $nested_parent_name) }}"
        label="Longitude"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Address Extra Information</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('building', $nested_parent_name) }}"
        label="Building"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('floor', $nested_parent_name) }}"
        label="Floor"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('unit', $nested_parent_name) }}"
        label="Unit"
    />
</section>




