<x-layout::client title="{{ $user->name }} | Contacts">
    <x-tabs :tabs="UserProfileTabs::tabs()">
        <x-card description="Visualise & Edit your contact details">
            <x-table.related.contacts
                :data="$user->contacts"
                :resource="$user"
                :trigger="false"
            />
        </x-card>
    </x-tabs>
</x-layout::client>
