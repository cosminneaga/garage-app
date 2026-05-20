@props(['id', 'resource', 'trigger' => false, 'triggerId' => ''])

@php
    $routeName = $resource->getTable();
@endphp

@if ($trigger)
    <x-button
        class="w-fit"
        :id="$triggerId"
        data-modal-target="{{ $id }}"
        data-modal-toggle="{{ $id }}"
        type="button"
        variant="default"
    >Add Contact</x-button>
@endif

<x-modal.wrapper :id="$id">
    <form
        action="{{ route($routeName . '.contact.store', $resource) }}"
        method="POST"
    >
        @csrf

        <x-form.field
            name="mobile"
            type="text"
            label="Mobile Phone"
            value="1112222333"
        />
        <x-form.field
            name="landline"
            type="text"
            label="Landline Phone"
            value="3331112222"
        />
        <x-form.field
            name="email"
            type="email"
            label="Email"
            value="test@email.com"
        />
        <x-form.field
            name="url"
            type="text"
            label="URL"
            value="http://example.com"
        />
        <x-form.field
            name="info"
            type="textarea"
            label="More Information"
            rows="10"
            value="Just around the corner"
        />

        <div class="flex gap-1">
            <x-button data-test="form-contact-create-submit">Submit</x-button>
        </div>
    </form>
</x-modal.wrapper>
