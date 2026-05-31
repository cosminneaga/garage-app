@php
    use App\Enums\Tabs\UserTabs;
    use App\Enums\UserPermission;
@endphp

<x-layout::index title="{{ $user->name }} | Contacts">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card description="Visualise & Edit your contact details">
            <x-table.related.contacts
                :data="$user->contacts"
                :resource="$user"
                edit
                delete
            />
        </x-card>
    </x-tabs>
</x-layout::index>
