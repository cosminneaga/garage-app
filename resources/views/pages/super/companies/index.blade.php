<x-layout::index title="List of all companies">
    <x-table.companies
        :data="$data"
        search_route="{{ route('super.companies.all') }}"
        prefix_route="super"
        edit
        delete
    />
</x-layout::index>
