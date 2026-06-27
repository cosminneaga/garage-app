@props(['id', 'resource', 'countries', 'trigger' => false])

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
    >Add Address</x-button>
@endif

<x-modal.wrapper
    id="{{ $ids['modal'] }}"
    size="6xl"
>
    <form
        action="{{ route($parentname . '.address.store', $resource) }}"
        method="POST"
    >
        @csrf

        <div class="grid grid-rows-1 gap-4 md:grid-cols-3">
            <x-form.content.address
                :countries="$countries"
                identifier="address"
            />
        </div>

        <div class="flex gap-1">
            <x-button
                id="{{ $ids['submit'] }}"
                type="submit"
            >Submit</x-button>
        </div>
    </form>
</x-modal.wrapper>
