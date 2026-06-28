<x-layout::index title="Administrators">
    <x-table.users
        chat
        :data="$administrators"
        :edit="Permission::can(UserPermission::USER, 'update')"
        routesPrefix="administrators"
    />
</x-layout::index>
