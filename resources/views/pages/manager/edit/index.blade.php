@php
    Session::flashInput([...$resource->toArray()]);
@endphp

<x-layout::index title="{{ $resource->name }} | Details">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card
            :title="$resource->name"
            description="Visualise & Edit {{ $resource->name }}'s details"
        >

            <form
                id="form-manager-update"
                action="{{ route('managers.update', $resource) }}"
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
                    identifier="manager_update"
                    :exclude="['password', 'password_confirmed']"
                />

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
                        >Delete User</x-button>
                    @endpermitted
                </div>
            </form>

            <x-modal.confirm
                id="manager-delete"
                type="delete"
                action="{{ route('managers.destroy', $resource->id) }}"
                message="Are you sure you want to remove {{ $resource->name }} from your team?"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
