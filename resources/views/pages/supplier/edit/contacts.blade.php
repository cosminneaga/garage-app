<x-layout::index title="{{ $resource->name }} | Contacts">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $resource->name }}'s contact details"
        >
            <x-table.related.contacts
                :data="$resource->contacts"
                :resource="$resource"
                :edit="Permission::can(UserPermission::CONTACT, 'show')"
                :delete="Permission::can(UserPermission::CONTACT, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
