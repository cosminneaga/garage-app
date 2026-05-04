@php
    use App\Enums\UserPermission;
    use App\Enums\Tabs\SupplierTabs;
    use App\Enums\SupplierType;

    $tab = request()->query('tab');
@endphp

<x-layout :title="$supplier->name">

    <x-wrapper.tab-resource
        name="supplier"
        :title="$supplier->name"
        subtitle="View & Update a Supplier"
        :tabs="SupplierTabs::ui()"
    >
        @if ($tab === SupplierTabs::DETAILS->value || !$tab)
            <x-bladewind.tab.content
                :name="SupplierTabs::DETAILS->value"
                active
            >
                <x-bladewind.card title="details">
                    <form
                        class="flex flex-col gap-4 text-start"
                        id="company-supplier-store"
                        :action="route('companies.supplier.store', $company)"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        <x-bladewind.input
                            name="name"
                            type="text"
                            label="Name"
                            :selected_value="$supplier->name"
                        />
                        <x-bladewind.input
                            name="code"
                            type="text"
                            label="Code"
                            :selected_value="$supplier->code"
                        />
                        <x-bladewind.select
                            name="type"
                            type="text"
                            value_key="value"
                            label="Type"
                            label_key="label"
                            :data="SupplierType::ui()"
                            :selected_value="$supplier->type->value"
                        />
                        <x-bladewind.input
                            name="tax_id"
                            type="text"
                            label="Tax ID"
                            :selected_value="$supplier->tax_id"
                        />
                        <x-bladewind.input
                            name="registration_number"
                            type="text"
                            label="Registration Number"
                            :selected_value="$supplier->registration_number"
                        />

                        <div class="flex gap-1">
                            <x-bladewind.button
                                class="w-fit"
                                type="primary"
                                can_submit
                            >update</x-bladewind.button>
                        </div>
                    </form>
                </x-bladewind.card>
            </x-bladewind.tab.content>
        @elseif ($tab === SupplierTabs::STATISTICS->value)
            <x-bladewind.tab.content
                :name="SupplierTabs::STATISTICS->value"
                active
            >
                Graphs goes here
            </x-bladewind.tab.content>
        @elseif ($tab === SupplierTabs::CONTACTS->value)
            <x-bladewind.tab.content
                :name="SupplierTabs::CONTACTS->value"
                active
            >
                <x-table.related.contacts
                    :data="$supplier->contacts"
                    :model="$supplier"
                />
            </x-bladewind.tab.content>
        @elseif ($tab === SupplierTabs::ADDRESSES->value)
            <x-bladewind.tab.content
                :name="SupplierTabs::ADDRESSES->value"
                active
            >
                <x-table.related.addresses
                    :data="$supplier->addresses"
                    :model="$supplier"
                    :actions="false"
                />
            </x-bladewind.tab.content>
        @endif
    </x-wrapper.tab-resource>

</x-layout>
