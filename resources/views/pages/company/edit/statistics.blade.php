@php
    use App\Enums\Tabs\CompanyTabs;
@endphp

<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        Data goes here
    </x-tabs>
</x-layout::index>
