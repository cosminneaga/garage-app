@php
    use App\Enums\Tabs\UserTabs;
    use App\Enums\UserPermission;

    $tab = request()->query('tab');
@endphp

<x-layout::index title="{{ $user->name }}">
    <x-tabs :tabs="UserTabs::ui()">
        <tab>
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
                    @method('PUT')

                    <img
                        class="h-24 w-24 rounded-full border-4 border-white object-cover"
                        src="{{ $user->image_path && !Str::isUrl($user->image_path) ? asset('storage/' . $user->image_path) : $user->image_path }}"
                        alt="alt"
                    >
                    <br>
                    <x-form.field
                        name="name"
                        type="text"
                        label="Name"
                        :value="$user->name"
                        test_identifier="user_update"
                    />
                    <x-form.field
                        name="email"
                        type="email"
                        label="Email"
                        :value="$user->email"
                        test_identifier="user_update"
                    />
                    <x-form.field
                        name="image"
                        type="image"
                        accept="image/*"
                        test_identifier="user_update"
                    />
                    <x-form.field
                        name="active"
                        type="toggle"
                        checked="{{ $user->active }}"
                        test_identifier="user_update"
                    >
                        <x-slot name="before">Inactive</x-slot>
                        <x-slot name="after">Active</x-slot>
                    </x-form.field>

                    <div class="mt-5 flex gap-1">
                        <x-button
                            class="w-fit"
                            id="form-user-update-submit"
                            form="form-user-update"
                            type="submit"
                            variant="default"
                        >Update Details</x-button>

                        @can(UserPermission::name(UserPermission::USER, 'delete'))
                            <x-button
                                data-modal-target="user-delete-modal"
                                data-modal-toggle="user-delete-modal"
                                id="user-delete-modal-trigger"
                                type="button"
                                variant="danger"
                            >Delete User</x-button>
                        @endcan
                    </div>
                </form>

                <x-modal.confirm
                    type="delete"
                    id="user-delete"
                    action="{{ route('users.destroy', $user->id) }}"
                    message="Are you sure you want to remove {{ $user->name }} from your team?"
                />
            </x-card>
        </tab>
        <tab>
            <x-card description="{{ $user->name }} statistics">
                Stats goes here
            </x-card>
        </tab>
        <tab>
            <x-card description="Visualise & Edit {{ $user->name }}'s contact details">
                <x-table.related.contacts
                    :data="$user->contacts"
                    :resource="$user"
                    :edit="Auth::user()->can(UserPermission::name(UserPermission::USER, 'update'))"
                    :delete="Auth::user()->can(UserPermission::name(UserPermission::USER, 'delete'))"
                />
            </x-card>
        </tab>
        <tab>
            <x-card description="Visualise & Edit {{ $user->name }}'s location details">
                <x-table.related.addresses
                    :data="$user->addresses"
                    :resource="$user"
                    :edit="Auth::user()->can(UserPermission::name(UserPermission::USER, 'update'))"
                    :delete="Auth::user()->can(UserPermission::name(UserPermission::USER, 'delete'))"
                    :countries="$countries"
                />
            </x-card>
        </tab>
    </x-tabs>
</x-layout::index>
