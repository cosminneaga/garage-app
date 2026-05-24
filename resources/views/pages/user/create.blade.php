@php
    use App\Models\Country;
    use App\Enums\UserRole;

    $enctype = config('app.env') === 'testing' ? 'application/x-www-form-urlencoded' : 'multipart/form-data';
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
            enctype="{{ $enctype }}"
        >
            @csrf

            <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">

                <div class="p-2">
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
                        value="false"
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

                </div>

                <div class="p-2">
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
                        type="text"
                        label="URL"
                    />
                    <x-form.field
                        name="contact[info]"
                        type="textarea"
                        label="More Information"
                        rows="10"
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
