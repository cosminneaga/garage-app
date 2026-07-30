<x-layout::index title="List of all suppliers">
    <x-table.suppliers
        :data="$data"
        search_route="{{ route('super.suppliers.all') }}"
        prefix_route="super"
        edit
        delete
    />
</x-layout::index>
