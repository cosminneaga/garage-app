@php
    use App\Enums\UserPermission;
    use App\Enums\Tabs\CompanyTabs;

    $tab = request()->query('tab');
@endphp

<x-layout::index title="{{ $company->name }}">
    <x-tabs :tabs="CompanyTabs::ui()">

        <x-card description="Visualise & Edit {{ $company->name }} details">
            <form
                id="form-company-update"
                action="{{ route('companies.update', $company) }}"
                method="POST"
                enctype="@enctype"
            >
                @csrf
                @method('PUT')

                <img
                    class="h-24 w-24 rounded-full border-4 border-white object-cover"
                    src="{{ $company->image_path && !Str::isUrl($company->image_path) ? asset('storage/' . $company->image_path) : $company->image_path }}"
                    alt="alt"
                >
                <br>
                <x-form.field
                    identifier="company"
                    name="name"
                    type="text"
                    label="Name"
                    :value="$company->name"
                />
                <x-form.field
                    identifier="company"
                    name="image"
                    type="image"
                    accept="image/*"
                />
                <x-form.field
                    identifier="company"
                    name="tax_id"
                    type="text"
                    label="Tax ID"
                    :value="$company->tax_id"
                />
                <x-form.field
                    identifier="company"
                    name="registration_number"
                    type="text"
                    label="Registration Number"
                    :value="$company->registration_number"
                />
                <x-form.field
                    identifier="company"
                    name="tax_value"
                    type="text"
                    label="Tax Value"
                    :value="$company->tax_value"
                />
                <x-form.field
                    identifier="company"
                    name="invoice_prefix"
                    type="text"
                    label="Invoice Prefix"
                    :value="$company->invoice_prefix"
                />

                <div class="mt-5 flex gap-1">
                    <x-button
                        class="w-fit"
                        id="form-company-update-button"
                        form="form-company-update"
                        type="submit"
                    >Update Details</x-button>

                    @permitted(UserPermission::COMPANY, 'delete')
                        <x-button
                            id="company-delete-modal-trigger"
                            data-modal-target="company-delete-modal"
                            data-modal-toggle="company-delete-modal"
                            type="button"
                            variant="danger"
                        >Delete Company</x-button>
                    @endpermitted
                </div>


            </form>
            <x-modal.confirm
                id="company-delete"
                type="delete"
                action="{{ route('companies.destroy', $company->id) }}"
                message="Are you sure you want to remove {{ $company->name }} from your list of companies?"
            />
        </x-card>

    </x-tabs>
    {{-- <x-tabs :tabs="CompanyTabs::ui()">
        <tab>
            <x-card description="Visualise & Edit {{ $company->name }} details">
                <form
                    id="form-company-update"
                    action="{{ route('companies.update', $company) }}"
                    method="POST"
                    enctype="@enctype"
                >
                    @csrf
                    @method('PUT')

                    <img
                        class="h-24 w-24 rounded-full border-4 border-white object-cover"
                        src="{{ $company->image_path && !Str::isUrl($company->image_path) ? asset('storage/' . $company->image_path) : $company->image_path }}"
                        alt="alt"
                    >
                    <br>
                    <x-form.field
                        name="name"
                        type="text"
                        label="Name"
                        :value="$company->name"
                        identifier="company"
                    />
                    <x-form.field
                        name="image"
                        type="image"
                        accept="image/*"
                        identifier="company"
                    />
                    <x-form.field
                        name="tax_id"
                        type="text"
                        label="Tax ID"
                        :value="$company->tax_id"
                        identifier="company"
                    />
                    <x-form.field
                        name="registration_number"
                        type="text"
                        label="Registration Number"
                        :value="$company->registration_number"
                        identifier="company"
                    />
                    <x-form.field
                        name="tax_value"
                        type="text"
                        label="Tax Value"
                        :value="$company->tax_value"
                        identifier="company"
                    />
                    <x-form.field
                        name="invoice_prefix"
                        type="text"
                        label="Invoice Prefix"
                        :value="$company->invoice_prefix"
                        identifier="company"
                    />

                    <div class="mt-5 flex gap-1">
                        <x-button
                            class="w-fit"
                            id="form-company-update-button"
                            form="form-company-update"
                            type="submit"
                        >Update Details</x-button>

                        @permitted(UserPermission::COMPANY, 'delete')
                            <x-button
                                data-modal-target="company-delete-modal"
                                data-modal-toggle="company-delete-modal"
                                id="company-delete-modal-trigger"
                                type="button"
                                variant="danger"
                            >Delete Company</x-button>
                        @endpermitted
                    </div>


                </form>
                <x-modal.confirm
                    id="company-delete"
                    type="delete"
                    action="{{ route('companies.destroy', $company->id) }}"
                    message="Are you sure you want to remove {{ $company->name }} from your list of companies?"
                />
            </x-card>
        </tab>

        <tab>
            Data goes here
        </tab>

        <tab>
            <x-card description="Visualise & Edit {{ $company->name }}'s registered members">
                <x-table.related.users
                    chat
                    :data="$members"
                    :resource="$company"
                    :countries="$countries"
                    :team="$team"
                    searchRoute="{{ route('companies.edit', $company) }}"
                    :edit="Permission::can(UserPermission::USER, 'update')"
                    :delete="Permission::can(UserPermission::COMPANY, 'update')"
                />

            </x-card>
        </tab>

        <tab>
            <x-card description="Visualise & Edit {{ $company->name }}'s contact details">
                <x-table.related.contacts
                    :data="$company->contacts"
                    :resource="$company"
                    :edit="Permission::can(UserPermission::CONTACT, 'update')"
                    :delete="Permission::can(UserPermission::COMPANY, 'update')"
                />
            </x-card>
        </tab>

        <tab>
            <x-card description="Visualise & Edit {{ $company->name }}'s location details">
                <x-table.related.addresses
                    :data="$company->addresses"
                    :resource="$company"
                    :countries="$countries"
                    :edit="Permission::can(UserPermission::ADDRESS, 'update')"
                    :delete="Permission::can(UserPermission::COMPANY, 'update')"
                />
            </x-card>
        </tab>

        <tab>
            <x-card description="Visualise $ Edit {{ $company->name }}'s suppliers">
                <x-table.related.suppliers
                    :data="$company->suppliers"
                    :resource="$company"
                    :countries="$countries"
                    :edit="Permission::can(UserPermission::SUPPLIER, 'update')"
                    :delete="Permission::can(UserPermission::COMPANY, 'update')"
                />
            </x-card>
        </tab>
    </x-tabs> --}}
</x-layout::index>
