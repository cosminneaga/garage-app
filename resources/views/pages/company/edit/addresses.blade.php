@php
    use App\Enums\UserPermission;
    use App\Enums\Tabs\CompanyTabs;
@endphp

<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card description="Visualise & Edit {{ $company->name }}'s location details">
            <x-table.related.addresses
                :data="$company->addresses"
                :resource="$company"
                :countries="$countries"
                :edit="Permission::can(UserPermission::ADDRESS, 'update')"
                :delete="Permission::can(UserPermission::COMPANY, 'update')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
