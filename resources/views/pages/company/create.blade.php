<x-layout::index title="Add company">
    <x-card
        title="Create a new company"
        description="Create a company, address & contact"
    >
        <form
            class="flex flex-col gap-4 text-start"
            action="{{ route('companies.store') }}"
            method="POST"
            enctype="@enctype"
        >
            @csrf

            <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">

                <div class="p-2">
                    <x-form.field
                        name="name"
                        type="text"
                        label="Name"
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
                    />
                    <x-form.field
                        name="registration_number"
                        type="text"
                        label="Registration Number"
                    />
                    <x-form.field
                        name="tax_value"
                        type="text"
                        label="Tax Value"
                    />
                    <x-form.field
                        name="invoice_prefix"
                        type="text"
                        label="Invoice Prefix"
                    />
                </div>

                <div class="p-2">
                    <x-form.field
                        name="address[number]"
                        type="text"
                        label="Number"
                    />
                    <x-form.field
                        name="address[street]"
                        type="text"
                        label="Street Name"
                    />
                    <x-form.field
                        name="address[postcode]"
                        type="text"
                        label="Postcode"
                    />
                    <x-form.field
                        name="address[country_id]"
                        type="select"
                        label="Select a country"
                        select_map_label="name"
                        select_map_value="id"
                        :options="$countries"
                    />

                    <h3 class="text-lg font-bold">Location</h3>
                    <hr class="bg-neutral-quaternary mb-8 mt-2 h-px border-0">
                    <x-form.field
                        name="address[coordinates][latitude]"
                        type="text"
                        label="Latitude"
                    />
                    <x-form.field
                        name="address[coordinates][longitude]"
                        type="text"
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
                        name="contact[info]"
                        type="textarea"
                        label="More Information"
                        rows="15"
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
