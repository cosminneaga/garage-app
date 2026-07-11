<x-layout::index title="Team">
    <x-table.users
        :data="$users"
        :edit="Permission::can(UserPermission::USER, 'update')"
        :delete="Permission::can(UserPermission::USER, 'delete')"
        chat
        search_route="{{ route('users.index') }}"
    />
</x-layout::index>
