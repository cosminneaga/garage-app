<x-layout::index title="Team">
    <x-table.users
        :data="$managers"
        :edit="Permission::can(UserPermission::USER, 'update')"
        :delete="Permission::can(UserPermission::USER, 'delete')"
        chat
        routesPrefix="managers"
        searchRoute="{{ route('managers.index') }}"
    />
</x-layout::index>
