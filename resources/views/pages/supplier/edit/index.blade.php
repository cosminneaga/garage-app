@php
    use App\Enums\UserPermission;
    use App\Enums\Tabs\SupplierTabs;
    use App\Enums\SupplierType;
@endphp

<x-layout::index title="{{ $supplier->name }} | Details">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card
            :title="$supplier->name"
            description="Visualise & Edit {{ $supplier->name }}'s details"
        >
            <form
                id="company-supplier-update"
                action="{{ route('companies.supplier.update', [$company, $supplier]) }}"
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
    </x-tabs>
</x-layout::index>
