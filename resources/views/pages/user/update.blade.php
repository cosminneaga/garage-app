<x-layout title="Update | {{ $user->name }}">
    <x-form.form-wrapper
        class=""
        title="update user details"
        description="Update user details, address & contact"
    >
        <div class="grid grid-rows-1 md:grid-cols-3 gap-1">
            <div class="border border-white px-3 py-6">
                <form
                    class="flex flex-col gap-4"
                    action="{{ route('users.update', $user) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <h3 class="text-2xl font-bold underline">Details</h3>
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
                    <div>
                        <x-bladewind.toggle
                            name="active"
                            color="orange"
                            label="Active"
                            :checked="$user->active"
                        />
                    </div>

                    <div class="flex gap-1">
                        <x-bladewind.button
                            class="w-fit"
                            can_submit
                            size="small"
                        >Update Details</x-bladewind.button>
                        <x-bladewind.button
                            class="w-fit"
                            color="red"
                            size="small"
                        >Delete User</x-bladewind.button>
                    </div>

                </form>
            </div>

            <div
                class="border border-white px-3 py-6 col-span-2 overflow-hidden">
                <h3 class="text-2xl font-bold underline">Contacts</h3>
                <br>

                <div class="max-h-60 overflow-auto">
                    <x-bladewind.table
                        celled
                        divider="thin"
                        has_border
                        has_hover="false"
                        compact
                    >
                        <x-slot name="header">
                            <th>ID</th>
                            <th>Mobile</th>
                            <th>Landline</th>
                            <th>Email</th>
                            <th>URL</th>
                            <th>Info</th>
                            <th>Actions</th>
                        </x-slot>

                        @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->id }}</td>
                                <td>{{ $contact->mobile }}</td>
                                <td>{{ $contact->landline }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->url }}</td>
                                <td>{{ $contact->info }}</td>

                                <td>
                                    <div class="flex gap-1">
                                        <x-bladewind.button.circle
                                            icon="pencil-square"
                                            color="primary"
                                            size="tiny"
                                            outline
                                        />
                                        <form
                                            action="#"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <x-bladewind.button.circle
                                                icon="trash"
                                                color="red"
                                                size="tiny"
                                                outline
                                                can_submit
                                            />
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </x-bladewind.table>
                </div>
            </div>
        </div>

        <div class="grid grid-rows-1 md:grid-cols-3 gap-2">
            <div
                class="col-span-3 border border-white px-3 py-6 flex-1 flex flex-col gap-3 overflow-hidden">
                <h3 class="text-2xl font-bold underline">Addresses</h3>
                <br>
                <div class="overflow-hidden overflow-x-scroll">
                    <div class="min-w-230">
                        <x-bladewind.table
                            celled
                            divider="thin"
                            has_border
                            has_hover="false"
                        >
                            <x-slot name="header">
                                <th>ID</th>
                                <th>Number</th>
                                <th>Street</th>
                                <th>Postcode</th>
                                <th>Country</th>
                                <th>Longitude, Latitude</th>
                                <th>Extra</th>
                                <th>Actions</th>
                            </x-slot>

                            @foreach ($addresses as $address)
                                <tr>
                                    <td>{{ $address->id }}</td>
                                    <td>{{ $address->number }}</td>
                                    <td>{{ $address->street }}</td>
                                    <td>{{ $address->postcode }}</td>
                                    <td>{{ $address->country->name }}</td>
                                    <td>
                                        {{ $address->coordinates['longitude'] }},
                                        {{ $address->coordinates['latitude'] }}
                                    </td>
                                    <td>{{ $address->extra }}</td>
                                    <td>
                                        <div class="flex gap-1">
                                            <x-bladewind.button.circle
                                                icon="pencil-square"
                                                color="primary"
                                                size="tiny"
                                                outline
                                            />
                                            <form
                                                action="#"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <x-bladewind.button.circle
                                                    icon="trash"
                                                    color="red"
                                                    size="tiny"
                                                    outline
                                                    can_submit
                                                />
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-bladewind.table>
                    </div>
                </div>
            </div>
        </div>
    </x-form.form-wrapper>
</x-layout>
