<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $company->name }}'s contact details"
        >
            <x-table.related.contacts
                :data="$company->contacts"
                :resource="$company"
                :edit="Permission::can(UserPermission::CONTACT, 'show')"
                :delete="Permission::can(UserPermission::CONTACT, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
