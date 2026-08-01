<x-layout::index title="Removed Managers">
    <x-table.users
        :data="$managers"
        search_route="{{ route('managers.removed') }}"
        :restore="Permission::can(UserPermission::USER, 'restore')"
        restore_route="managers.restore"
    />
</x-layout::index>
