<x-layout::index title="Add User">
    <x-card
        title="Create manager member"
        description="Create a new manager details, address & contact"
    >
        <form
            class="flex flex-col gap-4 text-start"
            action="{{ route('managers.store') }}"
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
                        identifier="user"
                    />
                    <x-form.field
                        name="email"
                        type="email"
                        label="Email"
                        identifier="user"
                    />
                    <x-form.field
                        name="image"
                        type="image"
                        accept="image/*"
                        identifier="user"
                    />
                    <x-form.field
                        name="password"
                        type="password"
                        label="Password"
                        identifier="user"
                    />
                    <x-form.field
                        name="password_confirmed"
                        type="password"
                        label="Password Confirmation"
                        identifier="user"
                    />
                    <x-form.field
                        name="role"
                        type="select"
                        label="Select a role"
                        :options="UserRole::ui()"
                        identifier="user"
                    />
                    <x-form.field
                        name="active"
                        type="checkbox"
                        identifier="user"
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
                        name="address[number]"
                        type="text"
                        label="Number"
                        identifier="user"
                    />
                    <x-form.field
                        name="address[street]"
                        type="text"
                        label="Street"
                        identifier="user"
                    />
                    <x-form.field
                        name="address[postcode]"
                        type="text"
                        label="Postcode"
                        identifier="user"
                    />
                    <x-form.field
                        name="address[country_id]"
                        type="select"
                        label="Select a country"
                        select_map_label="name"
                        select_map_value="id"
                        :options="$countries"
                        identifier="user"
                    />
                    <h3 class="text-lg font-bold">Location</h3>
                    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0" />
                    <x-form.field
                        name="address[coordinates][latitude]"
                        type="text"
                        label="Latitude"
                        identifier="user"
                    />
                    <x-form.field
                        name="address[coordinates][longitude]"
                        type="text"
                        label="Longitude"
                        identifier="user"
                    />
                </div>

                <div class="p-2">
                    <x-form.field
                        name="contact[mobile]"
                        type="text"
                        label="Mobile Phone"
                        identifier="user"
                    />
                    <x-form.field
                        name="contact[landline]"
                        type="text"
                        label="Landline Phone"
                        identifier="user"
                    />
                    <x-form.field
                        name="contact[email]"
                        type="email"
                        label="Email"
                        identifier="user"
                    />
                    <x-form.field
                        name="contact[url]"
                        type="text"
                        label="URL"
                        identifier="user"
                    />
                    <x-form.field
                        name="contact[info]"
                        type="textarea"
                        label="More Information"
                        rows="10"
                        identifier="user"
                    />
                </div>
            </div>

            <div class="flex gap-1">
                <x-button
                    id="form-managers-create-submit"
                    type="submit"
                >Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
