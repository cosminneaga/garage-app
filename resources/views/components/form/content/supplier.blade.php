<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => '',
    'nestedParentName' => false,
])

<section>
    <h3 class="text-lg font-bold">Supplier Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('name', $nestedParentName) }}"
        type="text"
        label="Name"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('code', $nestedParentName) }}"
        type="text"
        label="Code"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('type', $nestedParentName) }}"
        type="select"
        label="Type"
        select_map_label="label"
        select_map_value="value"
        :options="SupplierType::ui()"
        :selected_value="SupplierType::DISTRIBUTOR->value"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('tax_id', $nestedParentName) }}"
        type="text"
        label="Tax ID"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('registration_number', $nestedParentName) }}"
        type="text"
        label="Registration Number"
    />
</section>
