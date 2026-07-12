<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => '',
    'nested_parent_name' => false,
])

<section class="space-y-2">
    <h3 class="text-lg font-bold">Contact Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('email', $nested_parent_name) }}"
        type="email"
        label="Email"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('mobile', $nested_parent_name) }}"
        type="text"
        label="Mobile Phone"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Contact Extra Information</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('url', $nested_parent_name) }}"
        type="text"
        label="URL"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('landline', $nested_parent_name) }}"
        type="text"
        label="Landline Phone"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('info', $nested_parent_name) }}"
        type="textarea"
        label="More Information"
        rows="15"
    />
</section>
