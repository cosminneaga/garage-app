<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card description="Visualise & Edit {{ $resource->name }}'s suppliers">
            <x-table.related.suppliers
                :data="$resource->suppliers"
                :resource="$resource"
                :countries="$countries"
                edit
                delete
            />
        </x-card>
    </x-tabs>
</x-layout::index>
