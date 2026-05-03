<x-layout title="Update | {{ $user->name }}">
    <x-form.wrapper
        title="update user details"
        description="Update user details, address & contact"
    >

        <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
            <form
                id="form-users-update"
                action="{{ route('users.update', $user) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                <x-bladewind.card title="details">
                    <x-bladewind.avatar
                        class="mb-3"
                        size="big"
                        :image="$user->image_path && !Str::isUrl($user->image_path)
                            ? asset('storage/' . $user->image_path)
                            : $user->image_path"
                    />

                    <x-bladewind.input
                        name="name"
                        type="text"
                        label="Name"
                        :value="$user->name"
                    />
                    <x-bladewind.input
                        name="email"
                        type="email"
                        label="Email"
                        :value="$user->email"
                    />
                    <x-bladewind.filepicker
                        name="image"
                        accepted_file_types="image/*"
                    />
                    <div>
                        <x-bladewind.toggle
                            name="active"
                            color="orange"
                            label="Active"
                            :checked="$user->active"
                        />
                    </div>

                    <div class="mt-5 flex gap-1">
                        <x-bladewind.button
                            class="w-fit"
                            form="form-users-update"
                            size="small"
                            can_submit
                        >Update Details</x-bladewind.button>

                        <x-bladewind.button
                            class="w-fit"
                            form="form-users-delete"
                            color="red"
                            size="small"
                            can_submit
                        >Delete User</x-bladewind.button>
                    </div>
                </x-bladewind.card>

            </form>

            <div class="col-span-2">
                <x-table.related.contacts :resource="$user" />
                <br>
                <x-table.related.addresses :resource="$user" />
            </div>
        </div>

    </x-form.wrapper>

    <!-- USER DELETE FORM -->
    <form
        id="form-users-delete"
        action="{{ route('users.destroy', $user) }}"
        method="POST"
    >
        @csrf
        @method('DELETE')
    </form>
</x-layout>
