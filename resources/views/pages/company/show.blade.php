<x-layout :title="$company->name">
    <div class="flex items-end justify-between">

        <h1 class="text-2xl font-bold underline">
            {{ strtoupper($company->name) }}
        </h1>

        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::COMPANY,
            'update'))
            <a href="{{ route('companies.edit', $company) }}">
                <x-bladewind.button>
                    Edit {{ $company->name }}
                </x-bladewind.button>
            </a>
        @endcan
    </div>
    <br><br>

    <div class="grid grid-rows-2 gap-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <x-bladewind.contact-card
                class="col-span-1"
                :name="$company->name"
                {{-- :image="$company->image_path && !Str::isUrl($company->image_path) ? asset('storage/' . $company->image_path) : $company->image_path" --}}
            >
                <div class="mt-8">
                    <h3 class="font-bold">Details</h3>
                    <x-bladewind.listview>
                        <x-bladewind.listview.item>
                            Registration number:
                            {{ $company->registration_number }}
                        </x-bladewind.listview.item>
                        <x-bladewind.listview.item>
                            Tax value:
                            {{ $company->tax_value }}
                        </x-bladewind.listview.item>
                        <x-bladewind.listview.item>
                            Invoice prefix:
                            {{ $company->invoice_prefix }}
                        </x-bladewind.listview.item>
                    </x-bladewind.listview>
                </div>
            </x-bladewind.contact-card>
            <x-bladewind.card title="members">
                <x-table.users
                    divider="thin"
                    striped="true"
                    :users="$company->users()->get()"
                    message_action
                    edit_action
                />
            </x-bladewind.card>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
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

                    @foreach ($company->contacts()->get() as $contact)
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
            <x-bladewind.card
                class="overflow-auto"
                title="Addresses"
            >
                <x-bladewind.table>
                    <x-slot name="header">
                        <th>Mobile</th>
                        <th>Landline</th>
                        <th>Email</th>
                        <th>URL</th>
                        <th>Info</th>
                    </x-slot>

                    @foreach ($company->contacts()->get() as $contact)
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
    </div>
</x-layout>
