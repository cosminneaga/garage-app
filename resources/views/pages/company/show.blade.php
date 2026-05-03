@php
use App\Enums\UserPermission;
use App\Enums\Tabs\CompanyTabs;

$tab = request()->query('tab');
@endphp

<x-layout :title="$company->name">

    <div class="flex items-end justify-between">
        <h1 class="text-2xl font-bold underline">
            {{ strtoupper($company->name) }}
        </h1>

        @can(UserPermission::name(UserPermission::COMPANY, 'update'))
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
            @foreach (CompanyTabs::ui() as $heading)
                <x-bladewind.tab.heading
                    :name="$heading['value']"
                    :label="$heading['label']"
                    :active="$tab === $heading['value']"
                    url="/companies/{{ $company->id }}?tab={{ $heading['value'] }}"
                />
            @endforeach
        </x-slot:headings>

        <x-bladewind.tab.body>
            @if ($tab === CompanyTabs::DETAILS->value || !$tab)
                <x-bladewind.tab.content
                    :name="CompanyTabs::DETAILS->value"
                    active
                >
                    <x-bladewind.contact-card
                        class="col-span-1"
                        :name="$company->name"
                        :image="$company->image_path && !Str::isUrl($company->image_path)
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
            @elseif ($tab === CompanyTabs::STATISTICS->value)
                <x-bladewind.tab.content
                    :name="CompanyTabs::STATISTICS->value"
                    active
                >
                    Graphs goes here
                </x-bladewind.tab.content>
            @elseif ($tab === CompanyTabs::USERS->value)
                <x-bladewind.tab.content
                    :name="CompanyTabs::USERS->value"
                    active
                >
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
            @elseif ($tab === CompanyTabs::CONTACTS->value)
                <x-bladewind.tab.content
                    :name="CompanyTabs::CONTACTS->value"
                    active
                >
                    <x-table.related.contacts
                        :data="$company->contacts"
                        :model="$company"
                    />
                </x-bladewind.tab.content>
            @elseif ($tab === CompanyTabs::ADDRESSES->value)
                <x-bladewind.tab.content
                    :name="CompanyTabs::ADDRESSES->value"
                    active
                >
                    <x-table.related.addresses
                        :data="$company->addresses"
                        :model="$company"
                    />
                </x-bladewind.tab.content>
            @elseif ($tab === CompanyTabs::SUPPLIERS->value)
                <x-bladewind.tab.content
                    :name="CompanyTabs::SUPPLIERS->value"
                    active
                >
                    <x-table.related.suppliers
                        :data="$company->suppliers"
                        :model="$company"
                    />
                </x-bladewind.tab.content>
            @endif
        </x-bladewind.tab.body>
    </x-bladewind.tab>
</x-layout>
