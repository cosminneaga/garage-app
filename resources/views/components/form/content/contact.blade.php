<!-- this component is ready to use for empty fields
and old values but not for default values -->

@props([
    'identifier' => 'contact',
])

<section class="mt-4">
    <h3 class="text-lg font-bold">Contact Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-3 mt-2 h-px border-0">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="contact[email]"
            type="email"
            label="Email"
            value="{{ old('contact.email', '') }}"
        />
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="contact[mobile]"
            label="Mobile Phone"
            value="{{ old('contact.mobile', '') }}"
        />
    </div>
</section>

<section class="mt-4">
    <h3 class="text-lg font-bold">Contact Extra Information</h3>
    <hr class="bg-neutral-quaternary mb-3 mt-2 h-px border-0">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="contact[url]"
            label="URL"
            value="{{ old('contact.url', '') }}"
        />
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="contact[landline]"
            label="Landline Phone"
            value="{{ old('contact.landline', '') }}"
        />
    </div>
    <x-form.field.textarea
        identifier="{{ $identifier }}"
        name="contact[info]"
        label="More Information"
        rows="10"
        value="{{ old('contact.info', '') }}"
    />
</section>
