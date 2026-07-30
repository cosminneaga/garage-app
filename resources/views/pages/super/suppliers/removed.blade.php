<x-layout::index title="Removed suppliers">
    <x-table.suppliers
        :data="$suppliers"
        prefix_route="super"
        restore
    />
</x-layout::index>
