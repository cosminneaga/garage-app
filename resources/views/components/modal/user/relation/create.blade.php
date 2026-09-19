@props(['id', 'action' => '#', 'trigger' => false, 'countries' => []])

@php
    $ids = BladeModalHelper::ids($id);
@endphp

@if ($trigger)
    <x-button
        id="{{ $ids->get('trigger') }}"
        data-modal-target="{{ $ids->get('modal') }}"
        data-modal-toggle="{{ $ids->get('modal') }}"
        type="button"
    >
        Add user
    </x-button>
@endif

<x-modal.wrapper
    id="{{ $ids->get('modal') }}"
    title="Create & Attach an user"
    size="7xl"
>

    <form
        id="{{ $ids->get('form') }}"
        action="{{ $action }}"
        method="POST"
        enctype="@enctype"
    >
        @csrf

        <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">
            <div class="p-2">
                <x-form.content.user
                    identifier="user_create"
                    :exclude="['role']"
                />
            </div>

            <div class="p-2">
                <x-form.content.address
                    :countries="$countries"
                    identifier="user_create"
                    nested_parent_name="address"
                />
            </div>

            <div class="p-2">
                <x-form.content.contact
                    identifier="user_create"
                    nested_parent_name="contact"
                />
            </div>
        </div>

        <br>
        <x-button
            id="{{ $ids->get('submit') }}"
            type="submit"
        >Submit</x-button>
    </form>
</x-modal.wrapper>
