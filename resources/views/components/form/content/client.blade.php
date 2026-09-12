@props([
    'identifier' => '',
    'nested_parent_name' => false,
    'countries' => [],
])

<div class="grid grid-rows-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
    <section class="space-y-2">
        <h3 class="text-lg font-bold">Basic Information *</h3>
        <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />

        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('name', $nested_parent_name) }}"
            label="Name"
        />
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('email', $nested_parent_name) }}"
            type="email"
            label="Email"
        />
        <x-form.field.switch
            identifier="{{ $identifier }}"
            name="{{ Str::generateFormFieldName('active', $nested_parent_name) }}"
            checked
        >
            <x-slot name="before">
                Inactive
            </x-slot>
            <x-slot name="after">
                Active
            </x-slot>
        </x-form.field.switch>
    </section>

    <section class="space-y-2">
        <x-form.content.address
            identifier="client"
            :countries="$countries"
            nested_parent_name="address"
        />
    </section>

    <section class="space-y-2">
        <x-form.content.contact
            identifier="client"
            nested_parent_name="contact"
        />
    </section>
</div>
