@php
use App\Enums\UserPermission;
use App\Enums\Tabs\CompanyTabs;

$tab = request()->query('tab');
@endphp

<x-layout :title="$company->name">

    <x-wrapper.tab-resource
        name="company"
        :title="$company->name"
        subtitle="View & Update company details"
        :tabs="CompanyTabs::ui()"
    >
        @if ($tab === CompanyTabs::DETAILS->value || !$tab)
            <x-bladewind.tab.content
                :name="CompanyTabs::DETAILS->value"
                active
            >
                <form
                    id="form-companies-update"
                    action="{{ route('companies.update', $company) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    <x-bladewind.card title="details">
                        <x-bladewind.avatar
                            class="mb-3"
                            size="big"
                            :image="$company->image_path && !Str::isUrl($company->image_path)
                                ? asset('storage/' . $company->image_path)
                                : $company->image_path"
                        />

                        <x-bladewind.filepicker
                            name="image"
                            accepted_file_types="image/*"
                        />
                        <x-bladewind.input
                            name="name"
                            type="text"
                            label="Name"
                            :value="$company->name"
                        />
                        <x-bladewind.input
                            name="tax_id"
                            type="text"
                            label="Tax ID"
                            :value="$company->tax_id"
                        />
                        <x-bladewind.input
                            name="registration_number"
                            type="text"
                            label="Registration Number"
                            :value="$company->registration_number"
                        />
                        <x-bladewind.input
                            name="tax_value"
                            type="text"
                            label="Tax Value"
                            :value="$company->tax_value"
                        />
                        <x-bladewind.input
                            name="invoice_prefix"
                            type="text"
                            label="Invoice Prefix"
                            :value="$company->invoice_prefix"
                        />

                        <div class="mt-5 flex gap-1">
                            <x-bladewind.button
                                class="w-fit"
                                form="form-companies-update"
                                size="small"
                                can_submit
                            >Update Details</x-bladewind.button>

                            <x-bladewind.button
                                class="w-fit"
                                form="form-companies-delete"
                                color="red"
                                size="small"
                                can_submit
                            >Delete Company</x-bladewind.button>
                        </div>
                    </x-bladewind.card>
                </form>
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
    </x-wrapper.tab-resource>

    <!-- COMPANY DELETE FORM -->
    <form
        id="form-companies-delete"
        action="{{ route('companies.destroy', $company) }}"
        method="POST"
    >
        @csrf
        @method('DELETE')
    </form>
</x-layout>
