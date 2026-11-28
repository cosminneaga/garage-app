@php
    Session::flashInput($user->toArray());
@endphp

<x-layout::index title="{{ $user->name }} | Details">
    <x-tabs :tabs="UserTabs::tabs()">
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
                    src="{{ route('files.users.avatar', $user) }}"
                    alt="{{ $user->name }}"
                    title="{{ $user->name }}">
                <br>
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
                action="{{ route('users.destroy', $user->id) }}"
                message="Are you sure you want to remove {{ $user->name }} from your team?"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
