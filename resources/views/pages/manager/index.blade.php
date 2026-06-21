<x-layout::index title="Team">
    <x-table.users
        :data="$managers"
        chat
        :edit="Permission::can(UserPermission::USER, 'update')"
        :delete="Permission::can(UserPermission::USER, 'delete')"
        routesPrefix="managers"
    />
</x-layout::index>
