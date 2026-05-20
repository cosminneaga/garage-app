@php
    use App\Models\Country;
    use App\Enums\UserRole;
@endphp

<x-layout::index title="Add User">
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

            <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">

                <x-card>
                    <x-form.field
                        name="name"
                        type="text"
                        label="Name"
                    />
                    <x-form.field
                        name="email"
                        type="email"
                        label="Email"
                    />
                    <x-form.field
                        name="image"
                        type="image"
                        accept="image/*"
                    />
                    <x-form.field
                        name="password"
                        type="password"
                        label="Password"
                    />
                    <x-form.field
                        name="password_confirmed"
                        type="password"
                        label="Password Confirmation"
                    />
                    <x-form.field
                        name="role"
                        type="select"
                        label="Select a role"
                        :options="UserRole::ui()"
                    />
                    <x-form.field
                        name="active"
                        type="toggle"
                        checked="true"
                    >
                        <x-slot name="before">Inactive</x-slot>
                        <x-slot name="after">Active</x-slot>
                    </x-form.field>
                </x-card>

                <x-card title="address">

                    <x-form.field
                        name="address[number]"
                        type="text"
                        label="Number"
                    />
                    <x-form.field
                        name="address[street]"
                        type="text"
                        label="Street"
                    />
                    <x-form.field
                        name="address[postcode]"
                        type="text"
                        label="Postcode"
                    />
                    <x-form.field
                        name="address[country_id]"
                        type="select"
                        label="Select a country"
                        select_map_label="name"
                        select_map_value="id"
                        :options="Country::all()"
                    />
                    <h3 class="text-lg font-bold">Location</h3>
                    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">
                    <x-form.field
                        name="address[coordinates][latitude]"
                        type="text"
                        label="Latitude"
                    />
                    <x-form.field
                        name="address[coordinates][longitude]"
                        type="text"
                        label="Longitude"
                    />

                </x-card>

                <x-card>
                    <x-form.field
                        name="contact[mobile]"
                        type="text"
                        label="Mobile Phone"
                    />
                    <x-form.field
                        name="contact[landline]"
                        type="text"
                        label="Landline Phone"
                    />
                    <x-form.field
                        name="contact[email]"
                        type="email"
                        label="Email"
                    />
                    <x-form.field
                        name="contact[url]"
                        type="email"
                        label="URL"
                    />
                    <x-form.field
                        name="contact[info]"
                        type="textarea"
                        label="More Information"
                        rows="10"
                    />
                </x-card>
            </div>

            <div class="flex gap-1">
                <x-button
                    data-test="form-users-create-submit"
                    form="form-users-create"
                >Submit</x-button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout::index>
