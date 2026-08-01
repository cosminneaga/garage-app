<x-layout::index title="{{ $supplier->name }} | Statistics">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card description="{{ $supplier->name }} statistics">
            Stats goes here
        </x-card>
    </x-tabs>
</x-layout::index>
