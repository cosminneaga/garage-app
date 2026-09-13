<x-layout::index title="{{ $user->name }} | Statistics">
    <x-tabs :tabs="UserProfileTabs::tabs()">
        <x-card description="Visualise & Edit your statistics">
            Stats goes here
        </x-card>
    </x-tabs>
</x-layout::index>
