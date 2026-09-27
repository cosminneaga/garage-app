<x-layout::index title="Assigned Workorders">
    <x-card title="Assigned workorders">
        <x-table.workorders
            :data="$workorders"
        />
    </x-card>
</x-layout::index>
