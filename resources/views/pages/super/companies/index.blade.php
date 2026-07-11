<x-layout::index title="List of all companies">
    <x-table.companies
        :data="$data"
        search_route="{{ route('super.companies.all') }}"
    />
</x-layout::index>
