<x-layout::index title="Suppliers">
    <x-table.suppliers
        :data="$suppliers"
        searchRoute="{{ route('suppliers.all') }}"
        edit
        delete
        restore
    />
</x-layout::index>
