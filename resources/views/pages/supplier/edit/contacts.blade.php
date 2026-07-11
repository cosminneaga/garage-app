<x-layout::index title="{{ $supplier->name }} | Contacts">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $supplier->name }}'s contact details"
        >
            <x-table.related.contacts
                :data="$supplier->contacts"
                :resource="$supplier"
                :edit="Permission::can(UserPermission::CONTACT, 'update')"
                :delete="Permission::can(UserPermission::CONTACT, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
