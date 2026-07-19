@php
    Session::flashInput($user->toArray());
@endphp

<x-layout::index title="{{ $user->name }} | Profile">
    <x-tabs :tabs="UserProfileTabs::ui()">
        <x-card description="Visualise & Edit your details">
            <form
                action="{{ route('profile.users.update', $user) }}"
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

                <x-form.content.user
                    identifier="profile_update"
                    :exclude="['active', 'password', 'password_confirmed']"
                />

                <div class="mt-5 flex gap-1">
                    <x-button
                        id="profile-update-submit"
                        class="w-fit"
                        type="submit"
                    >Update Details</x-button>
                </div>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
