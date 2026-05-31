<x-layout::index title="Team">
    <x-table.users
        :data="$users"
        chat
        :edit="Permission::can(UserPermission::USER, 'update')"
        :delete="Permission::can(UserPermission::USER, 'delete')"
    />
</x-layout::index>
