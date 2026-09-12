<x-layout::index>
    <x-tabs :tabs="CompanyTabs::tabs()">
        <x-card description="Visualise & Edit {{ $resource->name }}'s suppliers">
            <x-table.related.suppliers
                :data="$resource->suppliers"
                :resource="$resource"
                :countries="$countries"
                :edit="Permission::can(UserPermission::SUPPLIER, 'show')"
                :delete="Permission::can(UserPermission::SUPPLIER, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
