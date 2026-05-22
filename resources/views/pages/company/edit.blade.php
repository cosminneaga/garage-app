@php
    use App\Enums\UserPermission;
    use App\Enums\Tabs\CompanyTabs;

    $tab = request()->query('tab');
@endphp

<x-layout::index title="{{ $company->name }}">

    <x-tabs :tabs="CompanyTabs::ui()">
        <tab>
            <x-card description="Visualise & Edit {{ $company->name }} details">
                <form
                    id="form-companies-update"
                    action="{{ route('companies.update', $company) }}"
                    method="POST"
                    enctype="multipart/form-data"
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
                        :value="$company->tax_id"
                    />
                    <x-form.field
                        name="registration_number"
                        type="text"
                        label="Registration Number"
                        :value="$company->registration_number"
                    />
                    <x-form.field
                        name="tax_value"
                        type="text"
                        label="Tax Value"
                        :value="$company->tax_value"
                    />
                    <x-form.field
                        name="invoice_prefix"
                        type="text"
                        label="Invoice Prefix"
                        :value="$company->invoice_prefix"
                    />

                    <div class="mt-5 flex gap-1">
                        <x-button
                            class="w-fit"
                            form="form-companies-update"
                            type="submit"
                        >Update Details</x-button>

                        @can(UserPermission::name(UserPermission::COMPANY, 'delete'))
                            <x-button
                                data-modal-target="company-delete-confirm"
                                data-modal-toggle="company-delete-confirm"
                                type="button"
                                variant="danger"
                            >Delete User</x-button>
                        @endcan
                    </div>

                    <x-modal.confirm
                        id="company-delete-confirm"
                        type="delete"
                        action="{{ route('companies.destroy', $company->id) }}"
                        message="Are you sure you want to remove {{ $company->name }} from your list of companies?"
                    />
                </form>
            </x-card>
        </tab>

        <tab>
            Data goes here
        </tab>

        <tab>
            <x-card description="Visualise & Edit {{ $company->name }}'s registered members">
                <x-table.users
                    :data="$company->users"
                    :resource="$company"
                    :edit="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'update'))"
                />
            </x-card>
        </tab>

        <tab>
            <x-card description="Visualise & Edit {{ $company->name }}'s contact details">
                <x-table.related.contacts
                    :data="$company->contacts"
                    :resource="$company"
                    :edit="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'update'))"
                    :delete="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'delete'))"
                />
            </x-card>
        </tab>

        <tab>
            <x-card description="Visualise & Edit {{ $company->name }}'s location details">
                <x-table.related.addresses
                    :data="$company->addresses"
                    :resource="$company"
                    :edit="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'update'))"
                    :delete="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'delete'))"
                />
            </x-card>
        </tab>

        <tab>
            Suppliers table coming soon...
        </tab>
    </x-tabs>
</x-layout::index>
