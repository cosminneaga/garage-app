<x-layout :title="$company->name">
    <div class="flex items-end justify-between">

        <h1 class="text-2xl font-bold underline">
            {{ strtoupper($company->name) }}
        </h1>

        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::COMPANY, 'update'))
            <a href="{{ route('companies.edit', $company) }}">
                <x-bladewind.button>
                    Edit {{ $company->name }}
                </x-bladewind.button>
            </a>
        @endcan
    </div>
    <br><br>

    <x-bladewind.tab name="company">
        <x-slot:headings>
            <x-bladewind.tab.heading name="details" label="Details" url="/companies/{{ $company->id }}?tab=details" active="{{ request()->query('tab') == 'details' }}" />
            <x-bladewind.tab.heading name="statistics" label="Statistics" url="/companies/{{ $company->id }}?tab=statistics" active="{{ request()->query('tab') == 'statistics' }}" />
            <x-bladewind.tab.heading name="members" label="Members" url="/companies/{{ $company->id }}?tab=members" active="{{ request()->query('tab') == 'members' }}" />
            <x-bladewind.tab.heading name="contacts" label="Contacts" url="/companies/{{ $company->id }}?tab=contacts" active="{{ request()->query('tab') == 'contacts' }}" />
            <x-bladewind.tab.heading name="addresses" label="Addresses" url="/companies/{{ $company->id }}?tab=addresses" active="{{ request()->query('tab') == 'addresses' }}" />
            <x-bladewind.tab.heading name="suppliers" label="Suppliers" url="/companies/{{ $company->id }}?tab=suppliers" active="{{ request()->query('tab') == 'suppliers' }}" />
        </x-slot:headings>

        <x-bladewind.tab.body>
            <x-bladewind.tab.content name="details" active="{{ request()->query('tab') == 'details' }}">
                <x-bladewind.contact-card
                    class="col-span-1"
                    :name="$company->name"
                    :image="$company->image_path &&
                    !Str::isUrl($company->image_path)
                        ? asset('storage/' . $company->image_path)
                        : $company->image_path"
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
            </x-bladewind.tab.content>

            <x-bladewind.tab.content name="statistics" active="{{ request()->query('tab') == 'statistics' }}">
                Graphs goes here
            </x-bladewind.tab.content>

            <x-bladewind.tab.content name="members" active="{{ request()->query('tab') == 'members' }}">
                <x-bladewind.card title="members">
                    <x-table.users
                        divider="thin"
                        striped="true"
                        :users="$company->users()->get()"
                        message_action
                        edit_action
                    />
                </x-bladewind.card>
            </x-bladewind.tab.content>

            <x-bladewind.tab.content name="contacts" active="{{ request()->query('tab') == 'contacts' }}">
                <x-table.related.contacts :resource="$company" />
            </x-bladewind.tab.content>

            <x-bladewind.tab.content name="addresses" active="{{ request()->query('tab') == 'addresses' }}">
                <x-table.related.addresses :resource="$company" />
            </x-bladewind.tab.content>

            <x-bladewind.tab.content name="suppliers" active="{{ request()->query('tab') == 'suppliers' }}">
                <x-table.related.suppliers :company="$company" />
            </x-bladewind.tab.content>
        </x-bladewind.tab.body>
    </x-bladewind.tab>
</x-layout>
