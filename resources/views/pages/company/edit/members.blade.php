@php
    use App\Enums\UserPermission;
    use App\Enums\Tabs\CompanyTabs;
@endphp

<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card description="Visualise & Edit {{ $company->name }}'s registered members">
            <x-table.related.users
                chat
                :data="$members"
                :resource="$company"
                :countries="$countries"
                :team="$team"
                searchRoute="{{ route('companies.edit', $company) }}"
                :edit="Permission::can(UserPermission::USER, 'update')"
                :delete="Permission::can(UserPermission::COMPANY, 'update')"
            />

        </x-card>
    </x-tabs>
</x-layout::index>
