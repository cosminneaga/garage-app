@php
    Session::flashInput($supplier->toArray());
@endphp

<x-layout::index title="{{ $supplier->name }} | Details">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card
            :title="$supplier->name"
            description="Visualise & Edit {{ $supplier->name }}'s details"
        >
            <form
                id="company-supplier-update"
                @isset($company)
                    :action="route('suppliers.companies.update', [
                        $company,
                        $supplier,
                    ])"
                @else
                    :action="route('supplier.update', $supplier)"
                @endisset
                method="POST"
            >
                @csrf
                @method ('PUT')

                <x-form.content.supplier identifier="supplier-update" />

                <div class="mt-5 flex gap-1">
                    <x-button
                        class="w-fit"
                        type="submit"
                    >UPDATE</x-button>
                </div>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
