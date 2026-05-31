<x-layout::index title="{{ $user->name }} | Addresses">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card description="Visualise & Edit your location details">
            <x-table.related.addresses
                :data="$user->addresses"
                :resource="$user"
                :countries="$countries"
                edit
                delete
            />
        </x-card>
    </x-tabs>
</x-layout::index>
