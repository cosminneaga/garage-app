<x-layout::index title="{{ $resource->name }} | Statistics">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card description="{{ $resource->name }} statistics">
            Stats goes here
        </x-card>
    </x-tabs>
</x-layout::index>
