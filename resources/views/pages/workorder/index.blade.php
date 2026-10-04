<x-layout::index title="Workorders">
    <x-card title="Workorders">
        <x-table.workorders
            :data="$workorders"
            :resource="$parent"
        />
    </x-card>
</x-layout::index>
