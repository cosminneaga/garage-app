@props(['name', 'company'])

@php
use \App\Enums\SupplierType;
use \App\Models\Country;
@endphp

<x-bladewind.modal
    title="Create new supplier for {{ $company->name }}"
    :name="$name"
    showActionButtons="false"
    size="xl"
>
    <form
        class="text-start flex flex-col gap-4"
        action="{{ route('companies.supplier.store', $company) }}"
        method="POST"
        id="{{ $name }}"
        x-data="{
            name: 'Supplier of AutoParts',
            code: 'NEMACODE486',
            type: 'distributor',
            tax_id: '3644758439',
            registration_number: '3644758439',
            address: {
                number: 2566,
                street: 'Subway Street',
                postcode: 'B546BFN',
                country_id: 1,
            },
            contact: {
                mobile: '974837483',
                landline: '974837483',
                email: 'supplier@net.com',
                url: 'https://supplierautoparts.com',
                info: '<h1>Hello World</h1><br><p>How are you today?</p>'
            }
        }"
    >
        @csrf

        <div class="grid grid-rows-1 md:grid-cols-3 gap-1">

            <x-bladewind.card title="details">
                <x-bladewind.input
                    name="name"
                    type="text"
                    label="Name"
                    x-model="name"
                />
                <x-bladewind.input
                    name="code"
                    type="text"
                    label="Code"
                    x-model="code"
                />
                <x-bladewind.select
                    name="type"
                    type="text"
                    label="Type"
                    label_key="label"
                    value_key="value"
                    :data="SupplierType::ui()"
                    selected_value="{{ SupplierType::DISTRIBUTOR->value }}"
                />
                <x-bladewind.input
                    name="tax_id"
                    type="text"
                    label="Tax ID"
                    x-model="tax_id"
                />
                <x-bladewind.input
                    name="registration_number"
                    type="text"
                    label="Registration Number"
                    x-model="registration_number"
                />
            </x-bladewind.card>

            <x-bladewind.card title="address">
                <x-bladewind.input
                    id="address_number"
                    name="address[number]"
                    type="number"
                    label="Number"
                    x-model="address.number"
                />
                <x-bladewind.input
                    id="address_street"
                    name="address[street]"
                    type="text"
                    label="Number"
                    x-model="address.street"
                />
                <x-bladewind.input
                    id="address_postcode"
                    name="address[postcode]"
                    type="text"
                    label="Postcode"
                    x-model="address.postcode"
                />
                <x-bladewind.select
                    id="address_country_id"
                    name="address_country_id"
                    value_key="id"
                    label="Select a country"
                    label_key="name"
                    flag_key="code"
                    :data="Country::all()"
                    selected_value="1"
                />
            </x-bladewind.card>

            <x-bladewind.card title="contact">
                <x-bladewind.input
                    id="contact_mobile"
                    name="contact[mobile]"
                    label="Mobile Phone"
                    x-model="contact.mobile"
                />
                <x-bladewind.input
                    id="contact_landline"
                    name="contact[landline]"
                    label="Landline Phone"
                    x-model="contact.landline"
                />
                <x-bladewind.input
                    id="contact_email"
                    name="contact[email]"
                    type="email"
                    label="Email"
                    x-model="contact.email"
                />
                <x-bladewind.input
                    id="contact_url"
                    name="contact[url]"
                    label="URL"
                    x-model="contact.url"
                />
                <x-bladewind.textarea
                    id="contact_info"
                    name="contact_info"
                    label="More Information"
                    toolbar
                    rows="10"
                    selected_value="contact.info"
                />
            </x-bladewind.card>
        </div>

        <div class="flex gap-1">
            <x-bladewind.button
                class="w-fit"
                type="primary"
                can_submit
            >Submit details</x-bladewind.button>
        </div>
    </form>
</x-bladewind.modal>
