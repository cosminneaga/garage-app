<x-layout::index title="Clients">
    <x-table.clients
        :data="$clients"
        :edit="Permission::can(UserPermission::CLIENT, 'show')"
        :delete="Permission::can(UserPermission::CLIENT, 'delete')"
        search_route="{{ route('clients.index') }}"
    />
</x-layout::index>
