<x-layout title="Add User">
    <x-form.form-wrapper
        title="create user"
        description="Create a new user details, address & contact"
    >
        <div class="grid grid-rows-1 md:grid-cols-3 gap-1">
            <div class="border border-white px-3 py-6">
                <form
                    class="flex flex-col gap-4"
                    id="form-users-create"
                    action="{{ route('users.store') }}"
                    method="POST"
                >
                    @csrf

                    <h3 class="text-2xl font-bold underline">Details</h3>
                    <x-bladewind.input
                        name="name"
                        type="text"
                        label="Name"
                        value="cosmin"
                    />
                    <x-bladewind.input
                        name="email"
                        type="email"
                        label="Email"
                        value="cos@mail.com"
                    />
                    <x-bladewind.input
                        name="password"
                        type="password"
                        label="Password"
                        viewable
                        value="password"
                    />
                    <div>
                        <x-bladewind.toggle
                            name="active"
                            color="orange"
                            label="Active"
                            :checked="true"
                        />
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
            </div>
        </div>
    </x-form.form-wrapper>
</x-layout>
