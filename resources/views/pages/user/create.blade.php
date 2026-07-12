<x-layout::index title="Add User">
    <x-card
        title="Create user"
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
                    <x-form.content.user identifier="user" />
                </div>

                <div class="p-2">
                    <x-form.content.address
                        :countries="$countries"
                        identifier="user"
                        nested_parent_name="address"
                    />
                </div>

                <div class="p-2">
                    <x-form.content.contact
                        identifier="user"
                        nested_parent_name="contact"
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
