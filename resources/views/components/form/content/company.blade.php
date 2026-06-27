<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => 'company',
    'nested_parent_name' => false,
])

<section>
    <h3 class="text-lg font-bold">Company Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('name', $nested_parent_name) }}"
        type="text"
        label="Name"
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
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('tax_value', $nested_parent_name) }}"
        type="text"
        label="Tax Value"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('invoice_prefix', $nested_parent_name) }}"
        type="text"
        label="Invoice Prefix"
    />
</section>

<section>
    <h3 class="text-lg font-bold">Media</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="company"
        name="image"
        type="image"
        accept="image/*"
    />
</section>
