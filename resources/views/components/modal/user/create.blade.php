@props(['id', 'resource', 'trigger' => false, 'countries', 'team'])

@php
    use App\Enums\UserRole;

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
    >Add User</x-button>
@endif

<x-modal.wrapper
    id="{{ $ids['modal'] }}"
    title="Create user"
    size="7xl"
>
    <form
        {{-- action="{{ route($parentname . '.user.attach', $resource) }}" --}}
        method="POST"
    >
        @csrf

        <x-form.field
            name="user"
            type="select"
            select_map_label="name"
            select_map_value="id"
            test_identifier="user_select"
            :options="$team"
        />

        <x-button
            type="submit"
            id="{{ $ids['submit-attach'] }}"
        >Attach User</x-button>
    </form>

    <form
        {{-- action="{{ route($parentname . '.user.store', $resource) }}" --}}
        method="POST"
    >
        @csrf

        <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">
            <div class="p-2">
                <x-form.field
                    name="name"
                    type="text"
                    label="Name"
                    test_identifier="user"
                />
                <x-form.field
                    name="email"
                    type="email"
                    label="Email"
                    test_identifier="user"
                />
                <x-form.field
                    name="image"
                    type="image"
                    accept="image/*"
                    test_identifier="user"
                />
                <x-form.field
                    name="password"
                    type="password"
                    label="Password"
                    test_identifier="user"
                />
                <x-form.field
                    name="password_confirmed"
                    type="password"
                    label="Password Confirmation"
                    test_identifier="user"
                />
                <x-form.field
                    name="role"
                    type="select"
                    label="Select a role"
                    :options="UserRole::ui()"
                    test_identifier="user"
                />
                <x-form.field
                    name="active"
                    type="checkbox"
                    test_identifier="user"
                >
                    <x-slot name="before">Inactive</x-slot>
                    <x-slot name="after">Active</x-slot>
                </x-form.field>
            </div>

            <div class="p-2">
                <x-form.field
                    name="address[number]"
                    type="text"
                    label="Number"
                    test_identifier="user"
                />
                <x-form.field
                    name="address[street]"
                    type="text"
                    label="Street"
                    test_identifier="user"
                />
                <x-form.field
                    name="address[postcode]"
                    type="text"
                    label="Postcode"
                    test_identifier="user"
                />
                <x-form.field
                    name="address[country_id]"
                    type="select"
                    label="Select a country"
                    select_map_label="name"
                    select_map_value="id"
                    :options="$countries"
                    test_identifier="user"
                />
                <h3 class="text-lg font-bold">Location</h3>
                <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">
                <x-form.field
                    name="address[coordinates][latitude]"
                    type="text"
                    label="Latitude"
                    test_identifier="user"
                />
                <x-form.field
                    name="address[coordinates][longitude]"
                    type="text"
                    label="Longitude"
                    test_identifier="user"
                />
            </div>

            <div class="p-2">
                <x-form.field
                    name="contact[mobile]"
                    type="text"
                    label="Mobile Phone"
                    test_identifier="user"
                />
                <x-form.field
                    name="contact[landline]"
                    type="text"
                    label="Landline Phone"
                    test_identifier="user"
                />
                <x-form.field
                    name="contact[email]"
                    type="email"
                    label="Email"
                    test_identifier="user"
                />
                <x-form.field
                    name="contact[url]"
                    type="text"
                    label="URL"
                    test_identifier="user"
                />
                <x-form.field
                    name="contact[info]"
                    type="textarea"
                    label="More Information"
                    rows="10"
                    test_identifier="user"
                />
            </div>
        </div>

        <div class="flex gap-1">
            <x-button
                id="{{ $ids['submit'] }}"
                type="submit"
            >Submit</x-button>
        </div>
    </form>
</x-modal.wrapper>
