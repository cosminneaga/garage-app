@php
    use App\Enums\Tabs\UserTabs;
    use App\Enums\UserPermission;

    $tab = request()->query('tab');
@endphp


<x-layout::index title="{{ $user->name }}">
    <x-tabs />

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

                <x-card title="details">

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
                    />
                    <x-form.field
                        name="email"
                        type="email"
                        label="Email"
                        :value="$user->email"
                    />
                    <x-form.field
                        name="image"
                        type="image"
                        accept="image/*"
                    />
                    <x-form.field
                        name="active"
                        type="toggle"
                        checked="true"
                    >
                        <x-slot name="before">Inactive</x-slot>
                        <x-slot name="after">Active</x-slot>
                    </x-form.field>

                    <div class="mt-5 flex gap-1">
                        <x-button
                            class="w-fit"
                            form="form-users-update"
                            size="small"
                            can_submit
                        >Update Details</x-button>

                        @can(UserPermission::name(UserPermission::USER, 'delete'))
                            <x-button
                                class="w-fit"
                                form="form-users-delete"
                                color="red"
                                size="small"
                                can_submit
                            >Delete User</x-button>
                        @endcan
                    </div>
                </x-card>

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
</x-layout::index>
