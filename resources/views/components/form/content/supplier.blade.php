<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => '',
    'nested_parent_name' => false,
])

<section class="space-y-2">
    <h3 class="text-lg font-bold">Supplier Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">

    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('name', $nested_parent_name) }}"
        label="Name"
        value="{{ old('name', '') }}"
    />
    <div class="grid grid-cols-2 gap-2">
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('code', $nested_parent_name) }}"
            label="Code"
            value="{{ old('code', '') }}"
        />
        <x-form.field.select
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('type', $nested_parent_name) }}"
            label="Type"
            select_map_label="label"
            select_map_value="value"
            :options="SupplierType::selectOptions()"
            :selected_value="SupplierType::DISTRIBUTOR->value"
            value="{{ old('type', '') }}"
        />
    </div>
    <div class="grid grid-cols-2 gap-2">
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('tax_id', $nested_parent_name) }}"
            label="Tax ID"
            value="{{ old('tax_id', '') }}"
        />
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('registration_number', $nested_parent_name) }}"
            label="Registration Number"
            value="{{ old('registration_number', '') }}"
        />
    </div>
</section>
