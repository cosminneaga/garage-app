@php
    $tab = request()->query('tab');
@endphp

<x-layout :title="$company->name">
    {{-- @dd($company) --}}
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
            <x-bladewind.tab.heading name="users" label="Members" url="/companies/{{ $company->id }}?tab=users" active="{{ request()->query('tab') == 'users' }}" />
            <x-bladewind.tab.heading name="contacts" label="Contacts" url="/companies/{{ $company->id }}?tab=contacts" active="{{ request()->query('tab') == 'contacts' }}" />
            <x-bladewind.tab.heading name="addresses" label="Addresses" url="/companies/{{ $company->id }}?tab=addresses" active="{{ request()->query('tab') == 'addresses' }}" />
            <x-bladewind.tab.heading name="suppliers" label="Suppliers" url="/companies/{{ $company->id }}?tab=suppliers" active="{{ request()->query('tab') == 'suppliers' }}" />
        </x-slot:headings>

        <x-bladewind.tab.body>
            <x-bladewind.tab.content name="details" active="{{ $tab === \App\Enums\Tabs\CompanyTabs::DETAILS->value }}">
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

            <x-bladewind.tab.content name="statistics" active="{{ $tab === \App\Enums\Tabs\CompanyTabs::STATISTICS->value }}">
                Graphs goes here
            </x-bladewind.tab.content>

            @if ($tab === \App\Enums\Tabs\CompanyTabs::USERS->value)
                <x-bladewind.tab.content name="users" active="{{ $tab === \App\Enums\Tabs\CompanyTabs::USERS->value }}">
                    <x-bladewind.card title="members">
                        <x-table.users
                            divider="thin"
                            striped="true"
                            :users="$company->users"
                            message_action
                            edit_action
                        />
                    </x-bladewind.card>
                </x-bladewind.tab.content>
            @endif

            @if ($tab === \App\Enums\Tabs\CompanyTabs::CONTACTS->value)
                <x-bladewind.tab.content name="contacts" active="{{ $tab === \App\Enums\Tabs\CompanyTabs::CONTACTS->value }}">
                    <x-table.related.contacts :data="$company->contacts" :model="$company" />
                </x-bladewind.tab.content>
            @endif

            @if ($tab === \App\Enums\Tabs\CompanyTabs::ADDRESSES->value)
                <x-bladewind.tab.content name="addresses" active="{{ $tab === \App\Enums\Tabs\CompanyTabs::ADDRESSES->value }}">
                    <x-table.related.addresses :data="$company->addresses" :model="$company" />
                </x-bladewind.tab.content>
            @endif

            @if ($tab === \App\Enums\Tabs\CompanyTabs::SUPPLIERS->value)
                <x-bladewind.tab.content name="suppliers" active="{{ $tab === \App\Enums\Tabs\CompanyTabs::SUPPLIERS->value }}">
                    <x-table.related.suppliers :data="$company->suppliers" :model="$company" />
                </x-bladewind.tab.content>
            @endif
        </x-bladewind.tab.body>
    </x-bladewind.tab>
</x-layout>
