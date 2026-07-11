<x-layout::index title="Removed Managers">
    <x-table.users
        :data="$managers"
        :restore="Permission::can(UserPermission::USER, 'restore')"
        routes_prefix="managers"
        search_route="{{ route('managers.removed') }}"
    />
</x-layout::index>
