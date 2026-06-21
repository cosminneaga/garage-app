<x-layout::index title="{{ $supplier->name }} | Addresses">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $supplier->name }}'s location details"
        >
            <x-table.related.addresses
                :data="$supplier->addresses"
                :resource="$supplier"
                :countries="$countries"
                :edit="Permission::can(UserPermission::SUPPLIER, 'update')"
                :delete="Permission::can(UserPermission::SUPPLIER, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
