<x-layout::index title="Removed Companies">
    <x-table.companies
        :data="$companies"
        :restore="Permission::can(UserPermission::COMPANY, 'restore')"
        search_route="{{ route('companies.removed') }}"
    />
</x-layout::index>
