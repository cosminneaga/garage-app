@props(['id', 'resource', 'countries' => [], 'trigger' => false])

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
    >Add Supplier</x-button>
@endif

<x-modal.wrapper
    id="{{ $ids['modal'] }}"
    size="6xl"
>
    <form
        action="{{ route($parentname . '.supplier.store', $resource) }}"
        method="POST"
    >
        @csrf

        <div class="grid grid-rows-1 gap-4 md:grid-cols-3">
            <x-form.content.supplier identifier="supplier" />

            <x-form.content.address
                identifier="supplier"
                :countries="$countries"
                nestedParentName="address"
            />

            <x-form.content.contact
                identifier="supplier"
                nestedParentName="contact"
            />
        </div>

        <x-button
            id="{{ $ids['submit'] }}"
            type="submit"
        >Submit</x-button>
    </form>
</x-modal.wrapper>
