<x-layout::index title="{{ $resource->name }} | Contacts">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $resource->name }}'s contact details"
        >
            <x-table.related.contacts
                :data="$resource->contacts"
                :resource="$resource"
                edit
                delete
            />
        </x-card>
    </x-tabs>
</x-layout::index>
