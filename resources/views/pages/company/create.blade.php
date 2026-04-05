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
                        value="Wurst TTD"
                        label="Name"
                    />
                    <x-bladewind.input
                        name="tax_id"
                        type="text"
                        value="432423423"
                        label="Tax ID"
                    />
                    <x-bladewind.input
                        name="registration_number"
                        type="text"
                        value="432423423"
                        label="Registration Number"
                    />
                    <x-bladewind.input
                        name="tax_value"
                        type="text"
                        value="34.00"
                        label="Tax Value"
                    />
                    <x-bladewind.input
                        name="invoice_prefix"
                        type="text"
                        value="INV"
                        label="Invoice Prefix"
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
                        value="254"
                        label="Number"
                    />
                    <x-bladewind.input
                        id="address_street"
                        name="address[street]"
                        type="text"
                        value="The Flowers Street"
                        label="Number"
                    />
                    <x-bladewind.input
                        id="address_postcode"
                        name="address[postcode]"
                        type="text"
                        value="T342234"
                        label="Postcode"
                    />
                    <x-bladewind.select
                        id="address_country_id"
                        name="address_country_id"
                        value_key="id"
                        label="Select a country"
                        label_key="name"
                        flag_key="code"
                        :data="$countries"
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
                        value="974837483"
                        label="Mobile Phone"
                    />

                    <x-bladewind.input
                        id="contact_landline"
                        name="contact[landline]"
                        value="974837483"
                        label="Landline Phone"
                    />

                    <x-bladewind.input
                        id="contact_email"
                        name="contact[email]"
                        type="email"
                        value="company@net.com"
                        label="Email"
                    />

                    <x-bladewind.input
                        id="contact_url"
                        name="contact[url]"
                        label="URL"
                    />

                    <x-bladewind.textarea
                        id="contact_info"
                        name="contact[info]"
                        label="More Information"
                    />
                </div>
            </div>

            <x-bladewind.button
                type="primary"
                can_submit
                class="w-fit"
            >Submit</x-bladewind.button>
        </form>
    </x-form.form-wrapper>
</x-layout>
