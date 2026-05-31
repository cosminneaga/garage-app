@php
    use App\Enums\UserPermission;
    use App\Enums\Tabs\SupplierTabs;
    use App\Enums\SupplierType;
@endphp

<x-layout::index title="{{ $supplier->name }} | Statistics">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card description="{{ $supplier->name }} statistics">
            Stats goes here
        </x-card>
    </x-tabs>
</x-layout::index>
