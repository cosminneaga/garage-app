<x-layout::index title="Client's contacts">
    <x-tabs :tabs="ClientTabs::tabs()">
        <x-card description="Visualise & Edit {{ $resource->name }} contacts">
            <x-table.related.contacts
                :data="$resource->contacts"
                :resource="$resource"
                :edit="Permission::can(UserPermission::CLIENT, 'update')"
                :delete="Permission::can(UserPermission::CLIENT, 'update')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
