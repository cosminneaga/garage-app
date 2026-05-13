@php
    use App\Models\Country;
    use App\Enums\UserRole;
@endphp

<x-layout title="Add User">
    <x-form.wrapper
        title="create team member"
        description="Create a new user details, address & contact"
    >
        <form
            class="flex flex-col gap-4 text-start"
            id="form-users-create"
            action="{{ route('users.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="grid grid-rows-1 gap-1 md:grid-cols-3">

                <x-bladewind.card title="details">
                    <x-bladewind.input
                        id="name"
                        name="name"
                        data-test="name"
                        type="text"
                        label="Name"
                    />
                    <x-bladewind.input
                        id="email"
                        name="email"
                        data-test="email"
                        type="email"
                        label="Email"
                    />
                    <x-bladewind.filepicker
                        name="image"
                        data-test="image"
                        accepted_file_types="image/*"
                    />
                    <x-bladewind.input
                        id="password"
                        name="password"
                        data-test="password"
                        type="password"
                        label="Password"
                        viewable
                    />
                    <x-bladewind.input
                        id="password_confirmed"
                        name="password_confirmed"
                        data-test="password_confirmed"
                        type="password"
                        label="Password Confirmation"
                        viewable
                    />
                    <x-bladewind.select
                        id="role"
                        name="role"
                        data-test="role"
                        value_key="name"
                        label="Select a role"
                        label_key="label"
                        :data="UserRole::ui()"
                    />
                    <x-bladewind.toggle
                        id="active"
                        name="active"
                        data-test="active"
                        color="orange"
                        label="Active"
                        :checked="true"
                    />
                </x-bladewind.card>

                <x-bladewind.card title="address">
                    <x-bladewind.input
                        id="address_number"
                        name="address[number]"
                        data-test="address_number"
                        type="number"
                        label="Number"
                    />
                    <x-bladewind.input
                        id="address_street"
                        name="address[street]"
                        data-test="address_street"
                        type="text"
                        label="Number"
                    />
                    <x-bladewind.input
                        id="address_postcode"
                        name="address[postcode]"
                        data-test="address_postcode"
                        type="text"
                        label="Postcode"
                    />
                    <x-bladewind.select
                        id="address_country_id"
                        name="address_country_id"
                        data-test="address_country_id"
                        value_key="id"
                        label="Select a country"
                        label_key="name"
                        flag_key="code"
                        :data="Country::all()"
                    />
                    <h3>Location</h3>
                    <br>
                    <x-bladewind.input
                        name="address[coordinates][latitude]"
                        data-test="address_coordinates_latitude"
                        type="text"
                        label="Latitude"
                    />
                    <x-bladewind.input
                        name="address[coordinates][longitude]"
                        data-test="address_coordinates_longitude"
                        type="text"
                        label="Longitude"
                    />
                </x-bladewind.card>

                <x-bladewind.card title="contact">
                    <x-bladewind.input
                        id="contact_mobile"
                        name="contact[mobile]"
                        data-test="contact_mobile"
                        label="Mobile Phone"
                    />

                    <x-bladewind.input
                        id="contact_landline"
                        name="contact[landline]"
                        data-test="contact_landline"
                        label="Landline Phone"
                    />

                    <x-bladewind.input
                        id="contact_email"
                        name="contact[email]"
                        data-test="contact_email"
                        type="email"
                        label="Email"
                    />

                    <x-bladewind.input
                        id="contact_url"
                        name="contact[url]"
                        data-test="contact_url"
                        label="URL"
                    />

                    <x-bladewind.textarea
                        id="contact_info"
                        name="contact_info"
                        data-test="contact_info"
                        label="More Information"
                        toolbar
                        rows="10"
                    />
                </x-bladewind.card>
            </div>

            <div class="flex gap-1">
                <x-bladewind.button
                    class="w-fit"
                    form="form-users-create"
                    data-test="user-create-btn"
                    can_submit
                    size="small"
                >Submit</x-bladewind.button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout>
