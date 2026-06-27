<x-layout::index title="Companies">
    <x-table.companies
        :data="$companies"
        :edit="Permission::can(UserPermission::COMPANY, 'update')"
        :delete="Permission::can(UserPermission::COMPANY, 'delete')"
    />
</x-layout::index>
