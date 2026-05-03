@php
use \App\Models\Country;
@endphp

<x-layout title="Add company">
    <x-form.wrapper
        title="Create a new company"
        description="Create a company, address & contact"
    >
        <form
            class="text-start flex flex-col gap-4"
            action="/companies"
            method="POST"
            enctype="multipart/form-data"
            x-data="{
                name: 'Wurst TTD',
                tax_id: '432423423',
                registration_number: '432423423',
                tax_value: 43.00,
                invoice_prefix: 'INV',
                address: {
                    number: 2566,
                    street: 'Subway Street',
                    postcode: 'B546BFN',
                    country_id: 1,
                },
                contact: {
                    mobile: '974837483',
                    landline: '974837483',
                    email: 'company@net.com',
                    url: 'https://cosminneaga.dev',
                    info: '<h1>Hello World</h1><br><p>How are you today?</p>'
                }
            }"
        >
            @csrf

            <div class="grid grid-rows-1 md:grid-cols-3 gap-1">

                <x-bladewind.card title="details">
                    <x-bladewind.filepicker
                        name="image"
                        accepted_file_types="image/*"
                    />
                    <x-bladewind.input
                        name="name"
                        type="text"
                        label="Name"
                        x-model="name"
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
                    <x-bladewind.input
                        name="tax_value"
                        type="text"
                        label="Tax Value"
                        x-model="tax_value"
                    />
                    <x-bladewind.input
                        name="invoice_prefix"
                        type="text"
                        label="Invoice Prefix"
                        x-model="invoice_prefix"
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
    </x-form.wrapper>
</x-layout>
