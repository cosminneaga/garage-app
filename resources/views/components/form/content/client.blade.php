@props([
    'identifier' => '',
    'nested_parent_name' => false,
    'countries' => [],
])

<section>
    <h3 class="text-lg font-bold">Client Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">

    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('name', $nested_parent_name) }}"
        label="Name"
        value="{{ old('name', '') }}"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('email', $nested_parent_name) }}"
        type="email"
        label="Email"
        value="{{ old('email', '') }}"
    />
    <x-form.field.switch
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('active', $nested_parent_name) }}"
        value="{{ old('active', 'false') }}"
    >
        <x-slot name="before">
            Inactive
        </x-slot>
        <x-slot name="after">
            Active
        </x-slot>
    </x-form.field.switch>
</section>
