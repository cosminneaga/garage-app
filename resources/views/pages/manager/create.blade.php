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
                    <x-form.content.address
                        identifier="user"
                        :countries="$countries"
                        nested_parent_name="address"
                    />
                </div>

                <div class="p-2">
                    <x-form.field
                        identifier="user"
                        name="contact[mobile]"
                        type="text"
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
                    id="form-managers-create-submit"
                    type="submit"
                >Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
