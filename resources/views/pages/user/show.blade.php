<x-layout title="User">
    <div class="flex items-end justify-between">

        <h1 class="text-2xl font-bold underline">
            {{ strtoupper($user->name) }}
        </h1>

        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::USER,
            'update'))
            <a href="{{ route('users.edit', $user) }}">
                <x-bladewind.button>
                    Edit {{ $user->name }}
                </x-bladewind.button>
            </a>
        @endcan
    </div>
    <br><br>

    <div class="grid grid-rows-2 gap-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <x-bladewind.contact-card
                class="col-span-1"
                :name="$user->name"
                :email="$user->email"
                :image="$user->image_path && !Str::isUrl($user->image_path) ? asset('storage/' . $user->image_path) : $user->image_path"
                position="{{ \App\Enums\UserRole::findByName($user->getRoleNames()[0])->name }}"
            >
                <div>
                    <x-active-tag :active="$user->active" />
                </div>
                <div>
                    <x-bladewind.listview>
                        <h3>Roles</h3>
                        @foreach ($user->getRoleNames() as $role)
                            <x-bladewind.listview.item>
                                ~
                                {{ \App\Enums\UserRole::findByName($role)->label() }}
                                ~
                            </x-bladewind.listview.item>
                        @endforeach
                    </x-bladewind.listview>
                </div>
            </x-bladewind.contact-card>

            <x-bladewind.card
                class="overflow-auto"
                title="Contacts"
            >
                <x-bladewind.table>
                    <x-slot name="header">
                        <th>Mobile</th>
                        <th>Landline</th>
                        <th>Email</th>
                        <th>URL</th>
                        <th>Info</th>
                    </x-slot>

                    @foreach ($user->contacts()->get() as $contact)
                        <tr>
                            <td>{{ $contact->mobile }}</td>
                            <td>{{ $contact->landline }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->url }}</td>
                            <td>{{ $contact->info }}</td>
                        </tr>
                    @endforeach
                </x-bladewind.table>
            </x-bladewind.card>
        </div>
        <div>
            <x-bladewind.card
                class="overflow-auto"
                title="Addresses"
            >
                <x-bladewind.table>
                    <x-slot name="header">
                        <th>Number</th>
                        <th>Street</th>
                        <th>Postcode</th>
                        <th>Country</th>
                        <th>Coordinates</th>
                        <th>Extra</th>
                    </x-slot>

                    @foreach ($user->addresses()->get() as $contact)
                        <tr>
                            <td>{{ $contact->number }}</td>
                            <td>{{ $contact->street }}</td>
                            <td>{{ $contact->postcode }}</td>
                            <td>{{ $contact->country->name }}</td>
                            <td>{{ implode(',', $contact->coordinates) }}</td>
                            <td>{{ $contact->extra }}</td>
                        </tr>
                    @endforeach
                </x-bladewind.table>
            </x-bladewind.card>
        </div>
    </div>
</x-layout>
