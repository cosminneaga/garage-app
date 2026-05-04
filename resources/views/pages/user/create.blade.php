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
            class="text-start flex flex-col gap-4"
            id="form-users-create"
            action="{{ route('users.store') }}"
            method="POST"
            enctype="multipart/form-data"
            x-data="{
                name: 'User',
                email: 'editor@garage.com',
                password: 'password',
                active: true,
                address: {
                    number: 2566,
                    street: 'Subway Street',
                    postcode: 'B546BFN',
                    country_id: 1,
                },
                contact: {
                    mobile: '974837483',
                    landline: '974837483',
                    email: 'company@net.com',
                    url: 'https://cosminneaga.dev',
                    info: '<h1>Hello</h1><p>How are you?</p>'
                }
            }"
        >
            @csrf

            <div class="grid grid-rows-1 md:grid-cols-3 gap-1">

                <x-bladewind.card title="details">
                    <x-bladewind.input
                        name="name"
                        type="text"
                        label="Name"
                        x-model="name"
                    />
                    <x-bladewind.input
                        name="email"
                        type="email"
                        label="Email"
                        x-model="email"
                    />
                    <x-bladewind.filepicker
                        name="image"
                        accepted_file_types="image/*"
                    />
                    <x-bladewind.input
                        name="password"
                        type="password"
                        label="Password"
                        viewable
                        x-model="password"
                    />
                    <x-bladewind.input
                        name="password_confirmed"
                        type="password"
                        label="Password Confirmation"
                        viewable
                        x-model="password"
                    />
                    <x-bladewind.select
                        id="role"
                        name="role"
                        value_key="name"
                        label="Select a role"
                        label_key="label"
                        :data="UserRole::ui()"
                        selected_value="user_editor"
                    />
                    <x-bladewind.toggle
                        name="active"
                        color="orange"
                        label="Active"
                        :checked="true"
                    />
                </x-bladewind.card>

                <x-bladewind.card title="address">
                    <x-bladewind.input
                        id="address_number"
                        name="address[number]"
                        type="number"
                        label="Number"
                        x-model="address.number"
                    />
                    <x-bladewind.input
                        id="address_street"
                        name="address[street]"
                        type="text"
                        label="Number"
                        x-model="address.street"
                    />
                    <x-bladewind.input
                        id="address_postcode"
                        name="address[postcode]"
                        type="text"
                        label="Postcode"
                        x-model="address.postcode"
                    />
                    <x-bladewind.select
                        id="address_country_id"
                        name="address_country_id"
                        value_key="id"
                        label="Select a country"
                        label_key="name"
                        flag_key="code"
                        :data="Country::all()"
                        selected_value="1"
                    />
                    <h3>Location</h3>
                    <br>
                    <x-bladewind.input
                        name="address[coordinates][latitude]"
                        type="text"
                        value="8.327832"
                        label="Latitude"
                    />
                    <x-bladewind.input
                        name="address[coordinates][longitude]"
                        type="text"
                        value="94.676743"
                        label="Longitude"
                    />
                </x-bladewind.card>

                <x-bladewind.card title="contact">
                    <x-bladewind.input
                        id="contact_mobile"
                        name="contact[mobile]"
                        label="Mobile Phone"
                        x-model="contact.mobile"
                    />

                    <x-bladewind.input
                        id="contact_landline"
                        name="contact[landline]"
                        label="Landline Phone"
                        x-model="contact.landline"
                    />

                    <x-bladewind.input
                        id="contact_email"
                        name="contact[email]"
                        type="email"
                        label="Email"
                        x-model="contact.email"
                    />

                    <x-bladewind.input
                        id="contact_url"
                        name="contact[url]"
                        label="URL"
                        x-model="contact.url"
                    />

                    <x-bladewind.textarea
                        id="contact_info"
                        name="contact_info"
                        label="More Information"
                        x-model="contact.info"
                        toolbar
                        rows="10"
                    />
                </x-bladewind.card>
            </div>

            <div class="flex gap-1">
                <x-bladewind.button
                    class="w-fit"
                    form="form-users-create"
                    can_submit
                    size="small"
                >Submit Details</x-bladewind.button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout>
