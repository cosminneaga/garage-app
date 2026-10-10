<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => '',
    'nested_parent_name' => false,
    'exclude' => [],
])

<section class="mt-5 space-y-2">
    <h3 class="text-lg font-bold">Basic Information *</h3>
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
</section>

<section class="mt-5 space-y-2">
    <h3 class="text-lg font-bold">Media</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">
    @if (collect($exclude)->doesntContain('image'))
        <x-form.field.image
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('image', $nested_parent_name) }}"
            accept="image/*"
        />
    @endif
</section>

<section class="mt-5 space-y-2">
    <h3 class="text-lg font-bold">Authentication *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">
    @if (collect($exclude)->doesntContain('password'))
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('password', $nested_parent_name) }}"
            type="password"
            label="Password"
            value="{{ old('password', '') }}"
        />
    @endif
    @if (collect($exclude)->doesntContain('password_confirmed'))
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('password_confirmed', $nested_parent_name) }}"
            type="password"
            label="Password Confirmation"
        />
    @endif
    @if (collect($exclude)->doesntContain('active'))
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
    @endif
</section>
