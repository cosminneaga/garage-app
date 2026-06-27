<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'countries' => [],
    'identifier' => '',
    'nested_parent_name' => false,
])

<section>
    <h3 class="text-lg font-bold">Address Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('street_number', $nested_parent_name) }}"
        type="text"
        label="Number"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('street', $nested_parent_name) }}"
        type="text"
        label="Street"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('postcode', $nested_parent_name) }}"
        type="text"
        label="Postcode"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('country_id', $nested_parent_name) }}"
        type="select"
        label="Select a country"
        select_map_label="name"
        select_map_value="id"
        :options="$countries"
        selected_value="1"
    />
</section>

<section>
    <h3 class="text-lg font-bold">Address Location</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('coordinates[latitude]', $nested_parent_name) }}"
        type="text"
        label="Latitude"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('coordinates[longitude]', $nested_parent_name) }}"
        type="text"
        label="Longitude"
    />
</section>

<section>
    <h3 class="text-lg font-bold">Address Extra Information</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('building', $nested_parent_name) }}"
        type="text"
        label="Building"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('floor', $nested_parent_name) }}"
        type="text"
        label="Floor"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('unit', $nested_parent_name) }}"
        type="text"
        label="Unit"
    />
</section>
