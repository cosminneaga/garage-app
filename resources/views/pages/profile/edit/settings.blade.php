<x-layout::index title="{{ $user->name }} | Settings">
    <x-tabs :tabs="UserTabs::ui()">
        Application Settings
    </x-tabs>
</x-layout::index>
