<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => 'company',
])

<section class="mt-4">
    <h3 class="text-lg font-bold">Company Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="name"
        label="Name"
        value="{{ old('name', '') }}"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="registration_number"
        label="Registration Number"
        value="{{ old('registration_number', '') }}"
    />
    <div class="grid grid-cols-2 gap-2">
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="tax_id"
            label="Tax ID"
            value="{{ old('tax_id', '') }}"
        />
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="tax_value"
            label="Tax Value"
            value="{{ old('tax_value', '') }}"
        />
    </div>
    <div class="grid grid-cols-2 gap-2">
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="invoice_prefix"
            label="Invoice Prefix"
            value="{{ old('invoice_prefix', '') }}"
        />
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="labour_rate_hourly"
            label="Labour Rate (hourly)"
            type="number"
            step="0.01"
            value="{{ old('labour_rate_hourly', '') }}"
        />
    </div>
</section>

<section class="mt-4">
    <h3 class="text-lg font-bold">Company Media</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">
    <x-form.field.image
        identifier="company"
        name="image"
        accept="image/*"
    />
</section>
