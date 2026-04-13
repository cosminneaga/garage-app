<x-layout>
    <x-form.wrapper
        title="update company details"
        description="Update company details, address & contact"
    >

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
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
                        :image="$company->image_path &&
                        !Str::isUrl($company->image_path)
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

                    <div class="flex gap-1 mt-5">
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

            <x-bladewind.card title="members">
                <x-table.users
                    divider="thin"
                    striped="true"
                    :users="$company->users()->get()"
                    message_action
                    edit_action
                />
            </x-bladewind.card>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
            <x-table.related.contacts :resource="$company" />
            <x-table.related.addresses :resource="$company" />
        </div>
    </x-form.wrapper>

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
