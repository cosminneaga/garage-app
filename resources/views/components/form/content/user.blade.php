<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => '',
    'nestedParentName' => false,
    'exclude' => [],
])

<section class="space-y-2">
    <h3 class="text-lg font-bold">User Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('name', $nestedParentName) }}"
        type="text"
        label="Name"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('email', $nestedParentName) }}"
        type="email"
        label="Email"
    />
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">User Media</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    @if (collect($exclude)->doesntContain('image'))
        <x-form.field
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('image', $nestedParentName) }}"
            type="image"
            accept="image/*"
        />
    @endif
</section>

<section class="space-y-2">
    <h3 class="text-lg font-bold">User Authentication *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    @if (collect($exclude)->doesntContain('password'))
        <x-form.field
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('password', $nestedParentName) }}"
            type="password"
            label="Password"
        />
    @endif
    @if (collect($exclude)->doesntContain('password_confirmed'))
        <x-form.field
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('password_confirmed', $nestedParentName) }}"
            type="password"
            label="Password Confirmation"
        />
    @endif
    @if (collect($exclude)->doesntContain('active'))
        <x-form.field
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('active', $nestedParentName) }}"
            type="checkbox"
            checked="{{ old('active') }}"
        >
            <x-slot name="before">
                Inactive
            </x-slot>
            <x-slot name="after">
                Active
            </x-slot>
        </x-form.field>
    @endif
</section>
