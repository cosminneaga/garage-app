<x-layout::index title="{{ $administrator->name }} | Statistics">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card description="{{ $administrator->name }} statistics">
            Stats goes here
        </x-card>
    </x-tabs>
</x-layout::index>
