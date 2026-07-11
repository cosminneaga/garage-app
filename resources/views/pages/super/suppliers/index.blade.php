<x-layout::index title="List of all suppliers">
    <x-table.suppliers
        :data="$data"
        search_route="{{ route('super.suppliers.all') }}"
    />
</x-layout::index>
