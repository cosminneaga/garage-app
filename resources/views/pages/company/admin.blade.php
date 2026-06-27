<x-layout::index title="Companies">
    <x-table.companies
        :data="$companies"
        searchRoute="{{ route('companies.all') }}"
        edit
        delete
        restore
    />
</x-layout::index>
