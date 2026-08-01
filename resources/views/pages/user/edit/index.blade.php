@php
    Session::flashInput($resource->toArray());
@endphp

<x-layout::index title="{{ $resource->name }} | Details">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card
            :title="$resource->name"
            description="Visualise & Edit {{ $resource->name }}'s details"
        >
            <form
                id="form-user-update"
                action="{{ route('users.update', $resource) }}"
                method="POST"
                enctype="@enctype"
            >
                @csrf
                @method ('PUT')

                <img
                    class="h-24 w-24 rounded-full border-4 border-white object-cover"
                    src="{{ $resource->image_path && !Str::isUrl($resource->image_path) ? asset('storage/' . $resource->image_path) : $resource->image_path }}"
                    alt="alt"
                />
                <br />
                <x-form.content.user
                    identifier="user_update"
                    :exclude="['role', 'password', 'password_confirmed']"
                />

                <div class="mt-5 flex gap-1">
                    @permitted(UserPermission::USER, 'update')
                        <x-button
                            class="w-fit"
                            id="form-user-update-submit"
                            form="form-user-update"
                            type="submit"
                            variant="default"
                        >Update Details</x-button>
                    @endpermitted

                    @permitted(UserPermission::USER, 'delete')
                        <x-button
                            id="user-delete-modal-trigger"
                            data-modal-target="user-delete-modal"
                            data-modal-toggle="user-delete-modal"
                            type="button"
                            variant="danger"
                        >Delete User</x-button>
                    @endpermitted
                </div>
            </form>

            <x-modal.confirm
                id="user-delete"
                type="delete"
                action="{{ route('users.destroy', $resource->id) }}"
                message="Are you sure you want to remove {{ $resource->name }} from your team?"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
