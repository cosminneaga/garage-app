<x-layout::index title="{{ $manager->name }} | Statistics">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card description="{{ $manager->name }} statistics">
            Stats goes here
        </x-card>
    </x-tabs>
</x-layout::index>
