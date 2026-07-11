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

<x-modal.wrapper
    id="{{ $ids['modal'] }}"
    size="2xl"
>
    <form
        action="{{ route('contacts.' . $parentname . '.store', $resource) }}"
        method="POST"
    >
        @csrf

        <div class="grid grid-rows-1 gap-4 md:grid-cols-2">
            <x-form.content.contact identifier="contact" />
        </div>

        <div class="mt-5 flex gap-1">
            <x-button
                id="{{ $ids['submit'] }}"
                type="submit"
            >Submit</x-button>
        </div>
    </form>
</x-modal.wrapper>
