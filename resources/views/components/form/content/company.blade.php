<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => 'company',
    'nestedParentName' => false,
])

<section class="space-y-2">
    <h3 class="text-lg font-bold">Company Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('name', $nestedParentName) }}"
        type="text"
        label="Name"
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
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('tax_value', $nestedParentName) }}"
        type="text"
        label="Tax Value"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('invoice_prefix', $nestedParentName) }}"
        type="text"
        label="Invoice Prefix"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Company Media</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="company"
        name="image"
        type="image"
        accept="image/*"
    />
</section>
