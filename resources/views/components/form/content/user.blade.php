<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => '',
    'nested_parent_name' => false,
])

<section>
    <h3 class="text-lg font-bold">User Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('name', $nested_parent_name) }}"
        type="text"
        label="Name"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('email', $nested_parent_name) }}"
        type="email"
        label="Email"
    />
</section>

<section>
    <h3 class="text-lg font-bold">User Media</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('image', $nested_parent_name) }}"
        type="image"
        accept="image/*"
    />
</section>

<section>
    <h3 class="text-lg font-bold">User Authentication *</h3>
    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('password', $nested_parent_name) }}"
        type="password"
        label="Password"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('password_confirmed', $nested_parent_name) }}"
        type="password"
        label="Password Confirmation"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('role', $nested_parent_name) }}"
        type="select"
        label="Select a role"
        :options="UserRole::ui()"
    />
    <x-form.field
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('active', $nested_parent_name) }}"
        type="checkbox"
    >
        <x-slot name="before">
            Inactive
        </x-slot>
        <x-slot name="after">
            Active
        </x-slot>
    </x-form.field>
</section>
