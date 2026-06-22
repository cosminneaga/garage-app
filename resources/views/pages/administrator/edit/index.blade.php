<x-layout::index title="{{ $administrator->name }} | Details">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card
            :title="$administrator->name"
            description="Visualise & Edit {{ $administrator->name }}'s details"
        >

            <form
                id="form-administrator-update"
                action="{{ route('administrators.update', $administrator) }}"
                method="POST"
                enctype="@enctype"
            >
                @csrf
                @method ('PUT')

                <img
                    class="h-24 w-24 rounded-full border-4 border-white object-cover"
                    src="{{ $administrator->image_path && !Str::isUrl($administrator->image_path) ? asset('storage/' . $administrator->image_path) : $administrator->image_path }}"
                    alt="alt"
                />
                <br />
                <x-form.field
                    identifier="user_update"
                    name="name"
                    type="text"
                    label="Name"
                    :value="$administrator->name"
                />
                <x-form.field
                    identifier="user_update"
                    name="email"
                    type="email"
                    label="Email"
                    :value="$administrator->email"
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
                    checked="{{ $administrator->active }}"
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
                        id="form-administrator-update-submit"
                        form="form-administrator-update"
                        type="submit"
                        variant="default"
                    >Update Details</x-button>
                </div>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
