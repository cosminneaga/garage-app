<x-layout::index title="Companies">
    <x-table.companies
        :data="$companies"
        :edit="Permission::can(UserPermission::COMPANY, 'show')"
        :delete="Permission::can(UserPermission::COMPANY, 'delete')"
        search_route="{{ route('companies.index') }}"
    />
</x-layout::index>
