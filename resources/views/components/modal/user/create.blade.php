@props([
    'id',
    'resource',
    'trigger' => false,
    'trigger_label' => 'Add User',
    'countries',
    'team',
])

@php
    $parentname = $resource->getTable();
    $ids = [
        'modal' => $parentname . '-' . $id . '-modal',
        'trigger' => $parentname . '-' . $id . '-modal-trigger',
        'submit' => $parentname . '-' . $id . '-modal-submit',
        'submit-attach' => $parentname . '-' . $id . '-modal-submit-attach',
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
    >{{ $trigger_label }}</x-button>
@endif

<x-modal.wrapper
    id="{{ $ids['modal'] }}"
    title="Create user"
    size="7xl"
>
    @if ($team->count())
        <form
            action="{{ route($parentname . '.user.attach', $resource) }}"
            method="POST"
        >
            @csrf
            @method ('PUT')

            <x-form.field
                identifier="user_select"
                name="id"
                type="select"
                select_map_label="name"
                select_map_value="id"
                :options="$team"
            />

            <x-button
                id="{{ $ids['submit-attach'] }}"
                type="submit"
            >Attach
                User</x-button>
        </form>
    @endif

    <form
        id="company-user-create"
        action="{{ route($parentname . '.user.store', $resource) }}"
        method="POST"
        enctype="@enctype"
    >
        @csrf

        <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">
            <div class="p-2">
                <x-form.field
                    identifier="user"
                    name="name"
                    type="text"
                    label="Name"
                />
                <x-form.field
                    identifier="user"
                    name="email"
                    type="email"
                    label="Email"
                />
                <x-form.field
                    identifier="user"
                    name="image"
                    type="image"
                    accept="image/*"
                />
                <x-form.field
                    identifier="user"
                    name="password"
                    type="password"
                    label="Password"
                />
                <x-form.field
                    identifier="user"
                    name="password_confirmed"
                    type="password"
                    label="Password Confirmation"
                />
                <x-form.field
                    identifier="user"
                    name="role"
                    type="select"
                    label="Select a role"
                    :options="UserRole::ui()"
                />
                <x-form.field
                    identifier="user"
                    name="active"
                    type="checkbox"
                >
                    <x-slot name="before">
                        Inactive
                    </x-slot>
                    <x-slot name="after">
                        Active
                    </x-slot>
                </x-form.field>
            </div>

            <div class="p-2">
                <x-form.field
                    identifier="user"
                    name="address[number]"
                    type="text"
                    label="Number"
                />
                <x-form.field
                    identifier="user"
                    name="address[street]"
                    type="text"
                    label="Street"
                />
                <x-form.field
                    identifier="user"
                    name="address[postcode]"
                    type="text"
                    label="Postcode"
                />
                <x-form.field
                    identifier="user"
                    name="address[country_id]"
                    type="select"
                    label="Select a country"
                    select_map_label="name"
                    select_map_value="id"
                    :options="$countries"
                />
                <h3 class="text-lg font-bold">Location</h3>
                <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
                <x-form.field
                    identifier="user"
                    name="address[coordinates][latitude]"
                    type="text"
                    label="Latitude"
                />
                <x-form.field
                    identifier="user"
                    name="address[coordinates][longitude]"
                    type="text"
                    label="Longitude"
                />
            </div>

            <div class="p-2">
                <x-form.field
                    identifier="user"
                    name="contact[mobile]"
                    type="text"
                    value="0774992903"
                    label="Mobile Phone"
                />
                <x-form.field
                    identifier="user"
                    name="contact[landline]"
                    type="text"
                    label="Landline Phone"
                />
                <x-form.field
                    identifier="user"
                    name="contact[email]"
                    type="email"
                    label="Email"
                />
                <x-form.field
                    identifier="user"
                    name="contact[url]"
                    type="text"
                    label="URL"
                />
                <x-form.field
                    identifier="user"
                    name="contact[info]"
                    type="textarea"
                    label="More Information"
                    rows="10"
                />
            </div>
        </div>

        <div class="flex gap-1">
            <x-button
                id="{{ $ids['submit'] }}"
                form="company-user-create"
                type="submit"
            >Submit</x-button>
        </div>
    </form>
</x-modal.wrapper>
