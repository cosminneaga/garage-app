<x-layout::index title="Invoices">
    <x-card>
        <x-table.related.invoices
            :data="$invoices"
            :resource="$resource"
        />
    </x-card>
</x-layout::index>
