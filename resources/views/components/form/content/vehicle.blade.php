@props([
    'identifier' => '',
    'nested_parent_name' => false,
])

<section class="space-y-2">
    <h3 class="text-lg font-bold">Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">

    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('vin', $nested_parent_name) }}"
        label="Vehicle Identification Number (VIN)"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('registration', $nested_parent_name) }}"
        label="Registration"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('first_visit_odometer', $nested_parent_name) }}"
        label="1st visit odometer"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('first_visit', $nested_parent_name) }}"
        label="First visit"
    />
    <x-form.field.select
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('fuel', $nested_parent_name) }}"
        label="Fuel"
        select_map_value="value"
        select_map_label="label"
        :options="FuelType::selectOptions()"
    />
    <x-form.field.select
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('status', $nested_parent_name) }}"
        label="Status"
        select_map_value="value"
        select_map_label="label"
        :options="VehicleStatus::selectOptions()"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Technical Data</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">

    <x-form.content.carinfo
        identifier="{{ $identifier }}"
        parent_name="{{ $nested_parent_name }}"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Extra Information</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">


    <x-form.field.textarea
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('technical_notes', $nested_parent_name) }}"
        label="Technical notes"
        rows="5"
    />
    <x-form.field.textarea
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('notes', $nested_parent_name) }}"
        label="General notes"
        rows="5"
    />
    <x-form.field.textarea
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('diagnostic_information', $nested_parent_name) }}"
        label="Diagnostic information"
        rows="5"
    />
</section>
