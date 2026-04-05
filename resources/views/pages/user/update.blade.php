<x-layout title="Update | {{ $user->name }}">
    <x-form.form-wrapper
        class=""
        title="update user details"
        description="Update user details, address & contact"
    >
        <form
            class="flex flex-col space-y-4 text-start"
            action="{{ route('users.update', $user) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="w-full flex gap-2">
                <div
                    class="border border-white px-3 py-6 flex-1 flex flex-col gap-3">
                    <h3 class="text-2xl font-bold underline">Details</h3>
                    <br>
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

                    <x-bladewind.button
                        class="w-fit"
                        can_submit
                    >Update Details</x-bladewind.button>
                </div>

                <div
                    class="border border-white px-3 py-6">
                    <h3 class="text-2xl font-bold underline">Contacts</h3>
                    <br>

                    <div class="overflow-y-hidden overflow-x-scroll max-w-150 w-auto">
                        <div class="w-225">
                            <x-bladewind.table
                                celled
                                divider="thin"
                                has_border
                                has_hover="false"
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

                                        <td class="flex gap-1">
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
                                        </td>
                                    </tr>
                                @endforeach
                            </x-bladewind.table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full flex gap-2">
                <div
                    class="border border-white px-3 py-6 flex-1 flex flex-col gap-3 scroll-y-auto">
                    <h3 class="text-2xl font-bold underline">Addresses</h3>
                    <br>
                    <div class="w-full">
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
                                    <td class="flex gap-1">
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
                                    </td>
                                </tr>
                            @endforeach
                        </x-bladewind.table>
                    </div>
                </div>
            </div>
        </form>
    </x-form.form-wrapper>
</x-layout>
