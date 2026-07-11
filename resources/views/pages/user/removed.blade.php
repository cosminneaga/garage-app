<x-layout::index title="Removed Team Members">
    <x-table.users
        :data="$users"
        :restore="Permission::can(UserPermission::USER, 'restore')"
        search_prefix="{{ route('users.removed') }}"
    />
</x-layout::index>
