@php
    use App\Models\Country;
    use App\Enums\UserRole;
@endphp

<x-layout::index title="Add User">
    <x-card
        title="create team member"
        description="Create a new user details, address & contact"
    >
        <form
            class="flex flex-col gap-4 text-start"
            action="{{ route('users.store') }}"
            method="POST"
            enctype="@enctype"
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
                        :options="Country::all()"
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
                    id="form-users-create-submit"
                    type="submit"
                >Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
