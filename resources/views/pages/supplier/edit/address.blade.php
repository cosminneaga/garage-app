@php
    Session::flashInput([
        'address' => json_decode(json_encode($address), true),
    ]);
@endphp

<x-layout::index title="{{ $supplier->name }} | Addresses">
    <x-tabs :tabs="SupplierTabs::tabs()">
        <x-card description="Visualise & Edit {{ $supplier->name }}'s location details">
            <form
                action="{{ route('address.supplier.edit', [$address, $supplier]) }}"
                method="post"
            >
                @csrf
                @method('PUT')

                <x-form.content.address identifier="supplier_edit" />

                <section class="mt-2">
                    <x-button type="submit">Update address</x-button>
                </section>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
