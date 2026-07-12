@props(['id', 'resource', 'countries' => [], 'trigger' => false])

@php
    $parentName = $resource->getTable();
    $ids = [
        'modal' => $parentName . '-' . $id . '-modal',
        'trigger' => $parentName . '-' . $id . '-modal-trigger',
        'submit' => $parentName . '-' . $id . '-modal-submit',
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
        action="{{ route('suppliers.' . $parentName . '.store', $resource) }}"
        method="POST"
    >
        @csrf

        <div class="grid grid-rows-1 gap-4 md:grid-cols-3">
            <x-form.content.supplier identifier="supplier" />

            <x-form.content.address
                identifier="supplier"
                :countries="$countries"
                nested_parent_name="address"
            />

            <x-form.content.contact
                identifier="supplier"
                nested_parent_name="contact"
            />
        </div>

        <x-button
            class="mt-5"
            id="{{ $ids['submit'] }}"
            type="submit"
        >Submit</x-button>
    </form>
</x-modal.wrapper>
