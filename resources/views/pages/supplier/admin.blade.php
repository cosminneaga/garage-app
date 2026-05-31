<x-layout::index title="Suppliers">
    <x-card title="Database Suppliers">
        <x-table.suppliers
            :data="$suppliers"
            :countries="$countries"
            :edit="Permission::can(UserPermission::SUPPLIER, 'update')"
            :delete="Permission::can(UserPermission::COMPANY, 'update')"
        />
    </x-card>
</x-layout::index>
