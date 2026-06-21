@props(['id', 'resource', 'trigger' => false])

@php
    $parentname = $resource->getTable();
    $ids = [
        'modal' => $parentname . '-' . $id . '-modal',
        'trigger' => $parentname . '-' . $id . '-modal-trigger',
        'submit' => $parentname . '-' . $id . '-modal-submit',
    ];
@endphp

@if ($trigger)
    <x-button
        class="w-fit"
        id="{{ $ids['trigger'] }}"
        data-modal-target="{{ $ids['modal'] }}"
        data-modal-toggle="{{ $ids['modal'] }}"
        type="button"
        variant="default"
    >Add Contact</x-button>
@endif

<x-modal.wrapper id="{{ $ids['modal'] }}">
    <form
        action="{{ route($parentname . '.contact.store', $resource) }}"
        method="POST"
    >
        @csrf

        <x-form.field
            name="mobile"
            type="text"
            label="Mobile Phone"
            identifier="contact"
        />
        <x-form.field
            name="landline"
            type="text"
            label="Landline Phone"
            identifier="contact"
        />
        <x-form.field
            name="email"
            type="email"
            label="Email"
            identifier="contact"
        />
        <x-form.field
            name="url"
            type="text"
            label="URL"
            identifier="contact"
        />
        <x-form.field
            name="info"
            type="textarea"
            label="More Information"
            identifier="contact"
        />

        <div class="flex gap-1">
            <x-button
                id="{{ $ids['submit'] }}"
                type="submit"
            >Submit</x-button>
        </div>
    </form>
</x-modal.wrapper>
