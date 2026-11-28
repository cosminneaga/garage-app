<x-layout::index title="{{ $user->name }} | Statistics">
    <x-tabs :tabs="UserTabs::tabs()">
        <x-card description="{{ $user->name }} statistics">
            Stats goes here
        </x-card>
    </x-tabs>
</x-layout::index>
