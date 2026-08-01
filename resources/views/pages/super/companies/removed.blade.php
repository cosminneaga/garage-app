<x-layout::index title="Companies">
    <x-table.companies
        :data="$data"
        search_route="{{ route('super.companies.removed') }}"
        prefix_route="super"
        restore
    />
</x-layout::index>
