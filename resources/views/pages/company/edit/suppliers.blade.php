<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card description="Visualise $ Edit {{ $company->name }}'s suppliers">
            <x-table.related.suppliers
                :data="$company->suppliers"
                :resource="$company"
                :countries="$countries"
                :edit="Permission::can(UserPermission::SUPPLIER, 'update')"
                :delete="Permission::can(UserPermission::SUPPLIER, 'update')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
