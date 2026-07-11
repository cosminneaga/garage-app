<x-layout::index title="Team">
    <x-table.users
        chat
        routes_prefix="managers"
        search_route="{{ route('managers.index') }}"
        :data="$managers"
        :edit="Permission::can(UserPermission::USER, 'update')"
        :delete="Permission::can(UserPermission::USER, 'delete')"
    />
</x-layout::index>
