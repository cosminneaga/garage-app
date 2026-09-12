@props([
    'identifier' => '',
    'nested_parent_name' => false,
    'makes' => [],
    'models' => [],
    'data' => [],
    'years' => [],
])

<div class="grid grid-rows-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
    <section class="space-y-2">
        <h3 class="text-lg font-bold">Basic Information *</h3>
        <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />

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
    </section>

    <section class="space-y-2">
        <h3 class="text-lg font-bold">Extra Information</h3>
        <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />

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
        <x-form.field.textarea
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('technical_notes', $nested_parent_name) }}"
            label="Technical notes"
        />
        <x-form.field.textarea
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('notes', $nested_parent_name) }}"
            label="General notes"
        />
        <x-form.field.textarea
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('diagnostic_information', $nested_parent_name) }}"
            label="Diagnostic information"
        />
    </section>

    <section class="space-y-2">
        <h3 class="text-lg font-bold">Technical Data</h3>
        <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />

        <x-form.field.select
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('vehicle_make_id', $nested_parent_name) }}"
            label="Vehicle make"
            select_map_value="id"
            select_map_label="name"
            :options="$makes"
        />
        <x-form.field.select
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('vehicle_model_id', $nested_parent_name) }}"
            label="Vehicle model"
            select_map_value="id"
            select_map_label="name"
            :options="$models"
        />
        <x-form.field.select
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('vehicle_data_id', $nested_parent_name) }}"
            label="Vehicle data"
            select_map_value="id"
            select_map_label="name"
            :options="$data"
        />
        <x-form.field.select
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('vehicle_year_id', $nested_parent_name) }}"
            label="Vehicle year"
            select_map_value="id"
            select_map_label="year"
            :options="$years"
        />
    </section>
</div>
