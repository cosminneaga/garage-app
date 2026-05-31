<x-layout::index title="Team">
    <x-table.users
        :data="$users"
        chat
        :edit="Permission::can(UserPermission::COMPANY, 'update')"
        :delete="Permission::can(UserPermission::COMPANY, 'delete')"
    />
</x-layout::index>
