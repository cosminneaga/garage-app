<x-layout::index title="{{ $user->name }} | Contacts">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $user->name }}'s contact details"
        >
            <x-table.related.contacts
                :data="$user->contacts"
                :resource="$user"
                :edit="Permission::can(UserPermission::CONTACT, 'update')"
                :delete="Permission::can(UserPermission::CONTACT, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
