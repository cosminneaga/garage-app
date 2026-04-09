<?php
$c = [['label' => 'Benin', 'value' => 'bj'], ['label' => 'Burkina Faso', 'value' => 'bf'], ['label' => 'Ghana', 'value' => 'gh'], ['label' => 'Nigeria', 'value' => 'ng'], ['label' => 'Kenya', 'value' => 'ke']];
?>


<x-layout>
    <x-form.form-wrapper
        title="Create a new company"
        description="Create a company, address & contact"
    >
        <form
            class="text-start flex flex-col gap-2"
            action="/companies"
            method="POST"
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
                    url: '',
                    info: ''
                }
            }"
        >
            @csrf

            <div class="w-full flex gap-2">
                <div
                    class="border border-white px-3 py-6 flex-1 flex flex-col gap-3">
                    <h3 class="text-2xl font-bold underline">Details</h3>
                    <br>

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
                </div>

                <div
                    class="border border-white px-3 py-6 flex-1 flex flex-col gap-3">
                    <h3 class="text-2xl font-bold underline">Address</h3>
                    <br>
                    {{-- <x-t-select
                            name="address"
                            label="Existing addresses"
                        >
                            @foreach ($addresses['user'] as $userAddress)
                                <option value="">
                                    {{ $userAddress['street'] }}
                                </option>
                            @endforeach
                            @foreach ($addresses['companies'] as $company)
                                <div>
                                    <option>
                                        <p style="font-weight: 800;">{{ $company['name'] }}</p>

                                        @foreach ($company['addresses'] as $companyAddresses)
                                            <option style="padding-left: 10px!important;">{{ $companyAddresses['street'] }}</option>
                                        @endforeach
                                    </option>
                                </div>
                            @endforeach
                        </x-t-select> --}}

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
                        :data="\App\Models\Country::all()"
                        selected_value="1"
                    />
                </div>
            </div>

            <div class="w-full flex">
                <div
                    class="border border-white px-3 py-6 flex-1 flex flex-col gap-3">
                    <h3 class="text-2xl font-bold underline">Contact</h3>
                    <br>

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
                        name="contact[info]"
                        label="More Information"
                        x-model="contact.info"
                    />
                </div>
            </div>

            <x-bladewind.button
                class="w-fit"
                type="primary"
                can_submit
            >Submit</x-bladewind.button>
        </form>
    </x-form.form-wrapper>
</x-layout>
