<x-layout::index title="{{ $resource->name }} | Contacts">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $resource->name }}'s contact details"
        >
            <x-table.related.contacts
                :data="$resource->contacts"
                :resource="$resource"
                :edit="Permission::can(UserPermission::USER, 'show')"
                :delete="Permission::can(UserPermission::USER, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
