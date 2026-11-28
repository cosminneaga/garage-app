@php
    Session::flashInput([
        'contact' => $resource->toArray()
    ]);
@endphp

<x-layout::index title="Contact">
    <x-tabs :tabs="UserTabs::tabs()">
        <x-card
            description="Visualise & Edit contact details"
        >
            {{-- <x-table.related.contacts
                :data="$resource->contacts"
                :resource="$resource"
                :edit="Permission::can(UserPermission::USER, 'show')"
                :delete="Permission::can(UserPermission::USER, 'delete')"
            /> --}}
            <x-form.content.contact
                identifier="user_edit"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
