<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => '',
    'nested_parent_name' => false,
])

<section class="space-y-2">
    <h3 class="text-lg font-bold">Supplier Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('name', $nested_parent_name) }}"
        type="text"
        label="Name"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('code', $nested_parent_name) }}"
        type="text"
        label="Code"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('type', $nested_parent_name) }}"
        type="select"
        label="Type"
        select_map_label="label"
        select_map_value="value"
        :options="SupplierType::ui()"
        :selected_value="SupplierType::DISTRIBUTOR->value"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('tax_id', $nested_parent_name) }}"
        type="text"
        label="Tax ID"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('registration_number', $nested_parent_name) }}"
        type="text"
        label="Registration Number"
    />
</section>
