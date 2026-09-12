<x-layout::index title="Company's stored clients">
    <x-tabs :tabs="CompanyTabs::tabs()">
        <x-card description="Visualise & Edit {{ $resource->name }}'s clients">
            <x-table.related.clients
                :data="$clients"
                :resource="$resource"
                :edit="Permission::can(UserPermission::CLIENT, 'show')"
                :delete="Permission::can(UserPermission::CLIENT, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
