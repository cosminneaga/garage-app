<x-layout::index title="{{ $user->name }} | Details">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card
            :title="$user->name"
            description="Visualise & Edit {{ $user->name }}'s details"
        >
            <form
                id="form-user-update"
                action="{{ route('users.update', $user) }}"
                method="POST"
                enctype="@enctype"
            >
                @csrf
                @method ('PUT')

                <img
                    class="h-24 w-24 rounded-full border-4 border-white object-cover"
                    src="{{ $user->image_path && !Str::isUrl($user->image_path) ? asset('storage/' . $user->image_path) : $user->image_path }}"
                    alt="alt"
                />
                <br />
                <x-form.field
                    identifier="user_update"
                    name="name"
                    type="text"
                    label="Name"
                    :value="$user->name"
                />
                <x-form.field
                    identifier="user_update"
                    name="email"
                    type="email"
                    label="Email"
                    :value="$user->email"
                />
                <x-form.field
                    identifier="user_update"
                    name="image"
                    type="image"
                    accept="image/*"
                />
                <x-form.field
                    identifier="user_update"
                    name="active"
                    type="toggle"
                    checked="{{ $user->active }}"
                >
                    <x-slot name="before">
                        Inactive
                    </x-slot>
                    <x-slot name="after">
                        Active
                    </x-slot>
                </x-form.field>

                <div class="mt-5 flex gap-1">
                    <x-button
                        class="w-fit"
                        id="form-user-update-submit"
                        form="form-user-update"
                        type="submit"
                        variant="default"
                    >Update Details</x-button>

                    @permitted(UserPermission::USER, 'delete')
                        <x-button
                            id="user-delete-modal-trigger"
                            data-modal-target="user-delete-modal"
                            data-modal-toggle="user-delete-modal"
                            type="button"
                            variant="danger"
                        >Delete
                            User</x-button>
                    @endpermitted
                </div>
            </form>

            <x-modal.confirm
                id="user-delete"
                type="delete"
                action="{{ route('users.destroy', $user->id) }}"
                message="Are you sure you want to remove {{ $user->name }} from your team?"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
