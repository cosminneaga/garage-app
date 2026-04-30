@props(['name', 'company'])

<x-bladewind.modal
    title="Create new supplier for {{ $company->name }}"
    :name="$name"
    showActionButtons="false"
>
    <form
        id="{{ $name }}"
        action="{{ route('companies.supplier.store', $company) }}"
        method="POST"
    >
        @csrf

        <x-bladewind.input
            name="name"
            type="text"
            label="Name"
            value="Supplier AutoParts"
        />
        <x-bladewind.input
            name="code"
            type="text"
            label="Code"
            value="NEMACODE486"
        />
        <x-bladewind.select
            name="type"
            type="text"
            label="Type"
            label_key="label"
            value_key="value"
            :data="\App\Enums\SupplierType::ui()"
            selected_value="{{ \App\Enums\SupplierType::DISTRIBUTOR->value }}"
        />
        <x-bladewind.input
            name="tax_id"
            type="text"
            label="Tax ID"
            value="3644758439"
        />
        <x-bladewind.input
            name="registration_number"
            type="text"
            label="Registration Number"
            value="3644758439"
        />

        <x-bladewind.button
            can_submit
        >create</x-bladewind.button>
    </form>
</x-bladewind.modal>
