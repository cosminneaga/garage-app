@php
    use App\Enums\Tabs\UserTabs;
    use App\Enums\UserPermission;

    $tab = request()->query('tab');
@endphp

<x-layout::index title="Profile | {{ $user->name }}">

    <x-tabs :tabs="[
        ...UserTabs::ui(),
        [
            'value' => 'settings',
            'label' => 'Settings',
            'slug' => 'settings',
        ],
    ]">

        <tab>
            <x-card description="Visualise & Edit your details">
                <form
                    action="{{ route('users.profile.update', $user) }}"
                    method="POST"
                    enctype="multipart/form-data"
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

                    <div class="mt-5 flex gap-1">
                        <x-button
                            class="w-fit"
                            type="submit"
                        >Update Details</x-button>
                    </div>

                </form>
            </x-card>
        </tab>

        <tab>
            Data goes here
        </tab>

        <tab>
            <x-table.related.contacts
                :data="$user->contacts"
                :resource="$user"
                edit
                delete
            />
        </tab>

        <tab>
            <x-table.related.addresses
                :data="$user->addresses"
                :resource="$user"
                edit
                delete
            />
        </tab>

        <tab>
            Application Settings
        </tab>

    </x-tabs>
</x-layout::index>
