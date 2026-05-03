@php
use \App\Enums\UserPermission;
use \App\Enums\Tabs\SupplierTabs;

$tab = request()->query('tab')
@endphp

<x-layout :title="$supplier->name">

    <div class="flex items-end justify-between">
        <h1 class="text-2xl font-bold underline">
            {{ strtoupper($supplier->name) }}
        </h1>

        @can(UserPermission::name(UserPermission::SUPPLIER, 'update'))
            <a :href="route('supplier.edit', $supplier)">
                <x-bladewind.button>
                    Edit {{ $supplier->name }}
                </x-bladewind.button>
            </a>
        @endcan
    </div>
    <br><br>

    <x-bladewind.tab name="supplier">
        <x-slot:headings>
            @foreach (SupplierTabs::ui() as $heading)
                <x-bladewind.tab.heading
                    :name="$heading['value']"
                    :label="$heading['label']"
                    :active="$tab === $heading['value']"
                    url="/companies/{{ $company->id }}/suppliers/{{ $supplier->id }}?tab={{ $heading['slug'] }}"
                />
            @endforeach
        </x-slot:headings>

        <x-bladewind.tab.body>
            @if($tab === SupplierTabs::DETAILS->value)

                <x-bladewind.tab.content
                    :name="SupplierTabs::DETAILS->value"
                    :active="$tab === SupplierTabs::DETAILS->value"
                >
                    <x-bladewind.contact-card
                        :name="$supplier->name"
                        :mobile="$supplier->code"
                        :birthday="$supplier->tax_id"
                        :department="$supplier->type->label()"
                        :position="$supplier->registration_number"
                    >

                    </x-bladewind.contact-card>
                </x-bladewind.tab.content>

            @elseif ($tab === SupplierTabs::STATISTICS->value)

                <x-bladewind.tab.content
                    :name="SupplierTabs::STATISTICS->value"
                    :active="$tab === SupplierTabs::STATISTICS->value"
                >
                    Graphs goes here
                </x-bladewind.tab.content>

            @elseif ($tab === SupplierTabs::CONTACTS->value)

                <x-bladewind.tab.content
                    :name="SupplierTabs::CONTACTS->value"
                    :active="$tab === SupplierTabs::CONTACTS->value"
                >
                    <x-table.related.contacts :data="$supplier->contacts" :model="$supplier" />
                </x-bladewind.tab.content>

            @elseif ($tab === SupplierTabs::ADDRESSES->value)
                <x-bladewind.tab.content
                    :name="SupplierTabs::ADDRESSES->value"
                    :active="$tab === SupplierTabs::ADDRESSES->value"
                >
                    <x-table.related.addresses :data="$supplier->addresses" :model="$supplier" />
                </x-bladewind.tab.content>

            @endif
        </x-bladewind.tab.body>
    </x-bladewind.tab>

</x-layout>
