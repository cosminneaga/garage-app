<x-layout::index title="{{ $user->name }} | Contacts">
    <x-tabs :tabs="UserProfileTabs::ui()">
        <x-card description="Visualise & Edit your contact details">
            <x-table.related.contacts
                :data="$user->contacts"
                :resource="$user"
                edit
                delete
            />
        </x-card>
    </x-tabs>
</x-layout::index>
