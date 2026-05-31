@php
    use App\Enums\Tabs\UserTabs;
    use App\Enums\UserPermission;
@endphp

<x-layout::index title="{{ $user->name }} | Statistics">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card description="{{ $user->name }} statistics">
            Stats goes here
        </x-card>
    </x-tabs>
</x-layout::index>
