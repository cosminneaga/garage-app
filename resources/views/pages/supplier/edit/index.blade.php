@php
    Session::flashInput($resource->toArray());
@endphp

<x-layout::index title="{{ $resource->name }} | Details">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card
            :title="$resource->name"
            description="Visualise & Edit {{ $resource->name }}'s details"
        >
            <form
                @isset($company)
                    :action="route('suppliers.companies.update', [
                        $company,
                        $resource,
                    ])"
                @else
                    :action="route('supplier.update', $resource)"
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
