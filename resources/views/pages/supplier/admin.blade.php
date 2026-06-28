<x-layout::index title="Suppliers">
    <x-table.suppliers
        :data="$suppliers"
        edit
        delete
        restore
        searchRoute="{{ route('suppliers.all') }}"
    />
</x-layout::index>
