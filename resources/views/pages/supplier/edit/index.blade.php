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
                @isset($company)
                    :action="route('suppliers.companies.update', [
                        $company,
                        $supplier,
                    ])"
                @else
                    :action="route('suppliers.update', $supplier)"
                @endisset
                method="POST"
            >
                @csrf
                @method ('PUT')

                <x-form.content.supplier identifier="supplier" />

                <div class="mt-5 flex gap-1">
                    <x-button
                        id="supplier_update_submit"
                        class="w-fit"
                        type="submit"
                    >UPDATE</x-button>
                </div>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
