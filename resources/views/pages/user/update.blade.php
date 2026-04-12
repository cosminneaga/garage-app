<x-layout title="Update | {{ $user->name }}">
    <x-form.wrapper
        title="update user details"
        description="Update user details, address & contact"
    >

        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <form
                id="form-users-update"
                action="{{ route('users.update', $user) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <x-bladewind.card title="details">
                    <x-bladewind.avatar
                        class="mb-3"
                        size="big"
                        :image="$user->image_path"
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
                    <div>
                        <x-bladewind.toggle
                            name="active"
                            color="orange"
                            label="Active"
                            :checked="$user->active"
                        />
                    </div>

                    <div class="flex gap-1 mt-5">
                        <x-bladewind.button
                            class="w-fit"
                            form="form-users-update"
                            size="small"
                            can_submit
                        >Update Details</x-bladewind.button>

                        <x-bladewind.button
                            class="w-fit"
                            form="form-user-delete"
                            color="red"
                            size="small"
                            can_submit
                        >Delete User</x-bladewind.button>
                    </div>
                </x-bladewind.card>

            </form>

            <x-bladewind.card
                class="col-span-2"
                title="contacts"
            >
                <div class="overflow-auto">
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
            </x-bladewind.card>
        </div>

        <div class="grid grid-cols-1 mt-2">
            <x-bladewind.card title="addresses">
                <div class="overflow-auto">
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
            </x-bladewind.card>
        </div>

    </x-form.wrapper>

    <!-- USER DELETE FORM -->
    <form
        id="form-user-delete"
        action="{{ route('users.destroy', $user) }}"
        method="POST"
    >
        @csrf
        @method('DELETE')
    </form>
</x-layout>
