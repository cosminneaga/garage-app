@php
    use App\Enums\Tabs\UserTabs;
    use App\Enums\UserPermission;
@endphp

<x-layout::index title="{{ $user->name }} | Addresses">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card description="Visualise & Edit {{ $user->name }}'s location details">
            <x-table.related.addresses
                :data="$user->addresses"
                :resource="$user"
                :countries="$countries"
                :edit="Permission::can(UserPermission::USER, 'update')"
                :delete="Permission::can(UserPermission::USER, 'delete')"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
