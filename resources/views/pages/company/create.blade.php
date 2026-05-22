@php
    use App\Models\Country;
@endphp

<x-layout::index title="Add company">
    <x-card
        title="Create a new company"
        description="Create a company, address & contact"
    >
        <form
            class="flex flex-col gap-4 text-start"
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

            <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">

                <div class="p-2">
                    <x-form.field
                        name="name"
                        type="text"
                        label="Name"
                        x-model="name"
                    />
                    <x-form.field
                        name="image"
                        type="image"
                        accept="image/*"
                    />
                    <x-form.field
                        name="tax_id"
                        type="text"
                        label="Tax ID"
                        x-model="tax_id"
                    />
                    <x-form.field
                        name="registration_number"
                        type="text"
                        label="Registration Number"
                        x-model="registration_number"
                    />
                    <x-form.field
                        name="tax_value"
                        type="text"
                        label="Tax Value"
                        x-model="tax_value"
                    />
                    <x-form.field
                        name="invoice_prefix"
                        type="text"
                        label="Invoice Prefix"
                        x-model="invoice_prefix"
                    />
                </div>

                <div class="p-2">
                    <x-form.field
                        name="address[number]"
                        type="text"
                        label="Number"
                        x-model="address.number"
                    />
                    <x-form.field
                        name="address[street]"
                        type="text"
                        label="Number"
                        x-model="address.street"
                    />
                    <x-form.field
                        name="address[postcode]"
                        type="text"
                        label="Postcode"
                        x-model="address.postcode"
                    />
                    <x-form.field
                        name="address[country_id]"
                        type="select"
                        label="Select a country"
                        :options="Country::all()"
                        select_map_label="name"
                        select_map_value="id"
                    />

                    <h3 class="text-lg font-bold">Location</h3>
                    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">
                    <x-form.field
                        name="address[coordinates][latitude]"
                        type="text"
                        value="8.327832"
                        label="Latitude"
                    />
                    <x-form.field
                        name="address[coordinates][longitude]"
                        type="text"
                        value="94.676743"
                        label="Longitude"
                    />
                </div>

                <div class="p-2">
                    <x-form.field
                        name="contact[mobile]"
                        type="text"
                        label="Mobile Phone"
                        x-model="contact.mobile"
                    />

                    <x-form.field
                        name="contact[landline]"
                        type="text"
                        label="Landline Phone"
                        x-model="contact.landline"
                    />

                    <x-form.field
                        name="contact[email]"
                        type="text"
                        type="email"
                        label="Email"
                        x-model="contact.email"
                    />

                    <x-form.field
                        name="contact[url]"
                        type="text"
                        label="URL"
                        x-model="contact.url"
                    />

                    <x-form.field
                        name="contact_info"
                        type="textarea"
                        label="More Information"
                        toolbar
                        rows="10"
                    />
                </div>

            </div>

            <div class="flex gap-1">
                <x-button
                    data-test="form-companies-create-submit"
                    type="submit"
                >Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
