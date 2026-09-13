<x-layout::index title="Client's statistics">
    <x-tabs :tabs="ClientTabs::tabs()">
        <x-card description="Visualise {{ $resource->name }} statistics">
            <h1>Stats</h1>
        </x-card>
    </x-tabs>
</x-layout::index>
