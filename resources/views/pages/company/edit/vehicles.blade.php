<x-layout::index title="Company's stored vehicles">
    <x-tabs :tabs="CompanyTabs::tabs()">
        <x-card description="Visualise & Edit {{ $company->name }}'s vehicles">
            <x-table.related.vehicles
                :data="$vehicles"
                :resource="$company"
                :edit="Permission::can(UserPermission::VEHICLE, 'show')"
                :delete="Permission::can(UserPermission::VEHICLE, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
