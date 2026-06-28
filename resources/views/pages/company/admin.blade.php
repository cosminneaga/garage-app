<x-layout::index title="Companies">
    <x-table.companies
        :data="$companies"
        edit
        delete
        restore
        searchRoute="{{ route('companies.all') }}"
    />
</x-layout::index>
