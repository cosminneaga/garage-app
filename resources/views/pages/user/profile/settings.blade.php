<x-layout::index title="{{ $user->name }} | Settings">
    <x-tabs :tabs="UserProfileTabs::tabs()">
        <x-card description="User application settings">
        </x-card>
    </x-tabs>
</x-layout::index>
