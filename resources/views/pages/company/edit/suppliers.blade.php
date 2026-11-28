<x-layout::index>
    <x-tabs :tabs="CompanyTabs::tabs()">
        <x-card description="Visualise & Edit {{ $company->name }}'s suppliers">
            <x-table.related.suppliers
                :data="$suppliers"
                :resource="$company"
                :edit="Permission::can(UserPermission::SUPPLIER, 'show')"
                :delete="Permission::can(UserPermission::SUPPLIER, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
