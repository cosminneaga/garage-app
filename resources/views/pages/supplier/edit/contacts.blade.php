@php
    use App\Enums\UserPermission;
    use App\Enums\Tabs\SupplierTabs;
    use App\Enums\SupplierType;
@endphp

<x-layout::index title="{{ $supplier->name }} | Contacts">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card description="Visualise & Edit {{ $supplier->name }}'s contact details">
            <x-table.related.contacts
                :data="$supplier->contacts"
                :resource="$supplier"
                :edit="Permission::can(UserPermission::SUPPLIER, 'update')"
                :delete="Permission::can(UserPermission::SUPPLIER, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
