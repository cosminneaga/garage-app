@php
    use App\Enums\Tabs\UserTabs;
    use App\Enums\UserPermissions;

    $tab = request()->query('tab');
@endphp

<x-layout title="{{ $user->name }}">

    <x-wrapper.tab-resource
        title="view & update user"
        subtitle="Update user details, address & contact"
        :tabs="UserTabs::ui()"
    >
        @if ($tab === UserTabs::DETAILS->value || !$tab)
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
        @elseif ($tab === UserTabs::STATISTICS->value)
            Data goes here
        @elseif ($tab === UserTabs::CONTACTS->value)
            <x-table.related.contacts
                :data="$user->contacts"
                :model="$user"
            />
        @elseif ($tab === UserTabs::ADDRESSES->value)
            <x-table.related.addresses
                :data="$user->addresses"
                :model="$user"
            />
        @endif
    </x-wrapper.tab-resource>

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
