<x-layout::index title="{{ $manager->name }} | Details">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card
            :title="$manager->name"
            description="Visualise & Edit {{ $manager->name }}'s details"
        >

            <form
                id="form-manager-update"
                action="{{ route('managers.update', $manager) }}"
                method="POST"
                enctype="@enctype"
            >
                @csrf
                @method ('PUT')

                <img
                    class="h-24 w-24 rounded-full border-4 border-white object-cover"
                    src="{{ $manager->image_path && !Str::isUrl($manager->image_path) ? asset('storage/' . $manager->image_path) : $manager->image_path }}"
                    alt="alt"
                />
                <br />
                <x-form.field
                    identifier="user_update"
                    name="name"
                    type="text"
                    label="Name"
                    :value="$manager->name"
                />
                <x-form.field
                    identifier="user_update"
                    name="email"
                    type="email"
                    label="Email"
                    :value="$manager->email"
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
                    checked="{{ $manager->active }}"
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
                        id="form-manager-update-submit"
                        form="form-manager-update"
                        type="submit"
                        variant="default"
                    >Update Details</x-button>

                    @permitted(UserPermission::USER, 'delete')
                        <x-button
                            id="manager-delete-modal-trigger"
                            data-modal-target="manager-delete-modal"
                            data-modal-toggle="manager-delete-modal"
                            type="button"
                            variant="danger"
                        >Delete
                            User</x-button>
                    @endpermitted
                </div>
            </form>

            <x-modal.confirm
                id="manager-delete"
                type="delete"
                action="{{ route('users.destroy', $manager->id) }}"
                message="Are you sure you want to remove {{ $manager->name }} from your team?"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
