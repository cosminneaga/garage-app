<x-layout::index title="{{ $user->name }} | Settings">
    <x-tabs :tabs="UserProfileTabs::ui()"> Application Settings </x-tabs>
</x-layout::index>
