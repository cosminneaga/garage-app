<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $company->name }}'s location details"
        >
            <x-table.related.addresses
                :data="$company->addresses"
                :resource="$company"
                :countries="$countries"
                :edit="Permission::can(UserPermission::ADDRESS, 'show')"
                :delete="Permission::can(UserPermission::ADDRESS, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
