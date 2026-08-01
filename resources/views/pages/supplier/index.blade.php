<x-layout::index title="Suppliers">
    <x-table.suppliers
        :data="$data"
        :edit="Permission::can(UserPermission::USER, 'update')"
        :delete="Permission::can(UserPermission::USER, 'delete')"
    />
</x-layout::index>
