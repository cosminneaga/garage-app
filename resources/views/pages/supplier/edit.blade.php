@php
    use App\Enums\UserPermission;
    use App\Enums\Tabs\SupplierTabs;
    use App\Enums\SupplierType;

    $tab = request()->query('tab');
@endphp

<x-layout::index :title="$supplier->name">

    <x-tabs :tabs="SupplierTabs::ui()">
        <tab>
            <x-card
                :title="$supplier->name"
                description="Visualise & Edit {{ $supplier->name }}'s details"
            >

                <form
                    id="company-supplier-store"
                    action="{{ route('companies.supplier.store', $company) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <x-form.field
                        name="name"
                        type="text"
                        label="Name"
                        :value="$supplier->name"
                    />
                    <x-form.field
                        name="code"
                        type="text"
                        label="Code"
                        :value="$supplier->code"
                    />
                    <x-form.field
                        name="type"
                        type="select"
                        label="Type"
                        select_map_label="label"
                        select_map_value="value"
                        :options="SupplierType::ui()"
                        :value="$supplier->type->value"
                    />
                    <x-form.field
                        name="tax_id"
                        type="text"
                        label="Tax ID"
                        :value="$supplier->tax_id"
                    />
                    <x-form.field
                        name="registration_number"
                        type="text"
                        label="Registration Number"
                        :value="$supplier->registration_number"
                    />

                    <div class="flex gap-1">
                        <x-button
                            class="w-fit"
                            type="submit"
                        >UPDATE</x-button>
                    </div>
                </form>

            </x-card>
        </tab>
        <tab>
            <x-card description="{{ $supplier->name }} statistics">
                Stats goes here
            </x-card>
        </tab>
        <tab>
            <x-card description="Visualise & Edit {{ $supplier->name }}'s contact details">
                <x-table.related.contacts
                    :data="$supplier->contacts"
                    :resource="$supplier"
                    :edit="Auth::user()->can(UserPermission::name(UserPermission::SUPPLIER, 'update'))"
                    :delete="Auth::user()->can(UserPermission::name(UserPermission::SUPPLIER, 'delete'))"
                />
            </x-card>
        </tab>
        <tab>
            <x-card description="Visualise & Edit {{ $supplier->name }}'s location details">
                <x-table.related.addresses
                    :data="$supplier->addresses"
                    :resource="$supplier"
                    :edit="Auth::user()->can(UserPermission::name(UserPermission::SUPPLIER, 'update'))"
                    :delete="Auth::user()->can(UserPermission::name(UserPermission::SUPPLIER, 'delete'))"
                />
            </x-card>
        </tab>
    </x-tabs>

</x-layout::index>
