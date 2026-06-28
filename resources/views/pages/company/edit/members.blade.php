<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $company->name }}'s registered members"
        >
            <x-table.related.users
                chat
                :team="$non_members"
                :data="$members"
                :resource="$company"
                :countries="$countries"
                :edit="Permission::can(UserPermission::USER, 'update')"
                :delete="Permission::can(UserPermission::COMPANY, 'update')"
                searchRoute="{{ route('companies.edit', $company) }}"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
