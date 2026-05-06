@php
    use App\Enums\Tabs\UserTabs;
    use App\Enums\UserPermission;

    $tab = request()->query('tab');
@endphp

<x-layout title="Profile | {{ $user->name }}">
    <x-wrapper.tab-resource
        title="view & update profile"
        subtitle="Update your own details, address & contact"
        :tabs="[...UserTabs::ui(), [
            'value' => 'settings',
            'label' => 'Settings',
            'slug' => 'settings'
        ]]"
    >
        @if ($tab === UserTabs::DETAILS->value || !$tab)
            <form
                id="form-users-update"
                action="{{ route('users.profile.update', $user) }}"
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

                    <div class="mt-5 flex gap-1">
                        <x-bladewind.button
                            class="w-fit"
                            form="form-users-update"
                            size="small"
                            can_submit
                        >Update Details</x-bladewind.button>
                    </div>
                </x-bladewind.card>

            </form>
        @elseif ($tab === UserTabs::STATISTICS->value)
            Data goes here
        @elseif ($tab === UserTabs::CONTACTS->value)
            <x-table.related.contacts
                :data="$user->contacts"
                :resource="$user"
            />
        @elseif ($tab === UserTabs::ADDRESSES->value)
            <x-table.related.addresses
                :data="$user->addresses"
                :resource="$user"
            />
        @elseif ($tab === 'settings')
            Application settings
        @endif
    </x-wrapper.tab-resource>
</x-layout>
