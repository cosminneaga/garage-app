<x-layout::index title="Client's addresses">
    <x-tabs :tabs="ClientTabs::tabs()">
        <x-card description="Visualise & Edit {{ $resource->name }} addresses">
            <x-table.related.addresses
                :data="$resource->addresses"
                :resource="$resource"
                :countries="$countries"
                :edit="Permission::can(UserPermission::CLIENT, 'update')"
                :delete="Permission::can(UserPermission::CLIENT, 'update')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
