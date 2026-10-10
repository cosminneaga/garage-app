<x-layout::client title="{{ $user->name }} | Addresses">
    <x-tabs :tabs="UserProfileTabs::tabs()">
        <x-card description="Visualise & Edit your location details">
            <x-table.related.addresses
                :data="$user->addresses"
                :resource="$user"
                :countries="$countries"
                :trigger="false"
            />
        </x-card>
    </x-tabs>
</x-layout::client>
