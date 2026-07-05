<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => '',
    'nestedParentName' => false,
])

<section class="space-y-2">
    <h3 class="text-lg font-bold">Contact Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('email', $nestedParentName) }}"
        type="email"
        label="Email"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('mobile', $nestedParentName) }}"
        type="text"
        label="Mobile Phone"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">Contact Extra Information</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('url', $nestedParentName) }}"
        type="text"
        label="URL"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('landline', $nestedParentName) }}"
        type="text"
        label="Landline Phone"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('info', $nestedParentName) }}"
        type="textarea"
        label="More Information"
        rows="15"
    />
</section>
