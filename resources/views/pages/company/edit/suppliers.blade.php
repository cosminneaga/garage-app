<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card description="Visualise $ Edit {{ $company->name }}'s suppliers">
            <x-table.related.suppliers
                :data="$company->suppliers"
                :resource="$company"
                :countries="$countries"
                :edit="Permission::can(UserPermission::SUPPLIER, 'show')"
                :delete="Permission::can(UserPermission::SUPPLIER, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
