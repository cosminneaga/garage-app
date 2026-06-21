<x-layout::index title="Removed Managers">
    <x-table.users
        :data="$managers"
        :restore="Permission::can(UserPermission::USER, 'restore')"
        routesPrefix="managers"
        searchPrefix="managers.removed"
    />
</x-layout::index>
