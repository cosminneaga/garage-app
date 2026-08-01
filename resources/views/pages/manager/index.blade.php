<x-layout::index title="Team">
    <x-table.users
        chat
        search_route="{{ route('managers.index') }}"
        :data="$data"
        :edit="Permission::can(UserPermission::USER, 'show')"
        :delete="Permission::can(UserPermission::USER, 'delete')"
        edit_route="managers.edit"
        delete_route="managers.destroy"
    />
</x-layout::index>
