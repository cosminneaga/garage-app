<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => 'company',
    'nested_parent_name' => false,
])

<section class="space-y-2">
    <h3 class="text-lg font-bold">Company Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('name', $nested_parent_name) }}"
        label="Name"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('tax_id', $nested_parent_name) }}"
        label="Tax ID"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('registration_number', $nested_parent_name) }}"
        label="Registration Number"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('tax_value', $nested_parent_name) }}"
        label="Tax Value"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('invoice_prefix', $nested_parent_name) }}"
        label="Invoice Prefix"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Company Media</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field.image
        identifier="company"
        name="image"
        accept="image/*"
    />
</section>
