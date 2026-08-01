<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $resource->name }}'s location details"
        >
            <x-table.related.addresses
                :data="$resource->addresses"
                :resource="$resource"
                :countries="$countries"
                edit
                delete
            />
        </x-card>
    </x-tabs>
</x-layout::index>
