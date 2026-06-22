<x-layout::index title="Administrators">
    <x-table.users
        :data="$administrators"
        chat
        :edit="Permission::can(UserPermission::USER, 'update')"
        routesPrefix="administrators"
    />
</x-layout::index>
