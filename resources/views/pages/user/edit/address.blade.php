@php
    Session::flashInput([
        'address' => $resource->toArray()
    ]);
@endphp

<x-layout::index title="Address">
    <x-tabs :tabs="UserTabs::tabs()">
        <x-card
            description="Visualise & Edit location details"
        >
            <x-form.content.address
                identifier="user_edit"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
