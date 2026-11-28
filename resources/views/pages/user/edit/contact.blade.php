@php
    Session::flashInput([
        'contact' => $contact->toArray()
    ]);
@endphp

<x-layout::index title="Contact">
    <x-tabs :tabs="UserTabs::tabs()">
        <x-card
            description="Visualise & Edit {{ $user->name }}'s contact details"
        >
            {{-- <x-table.related.contacts
                :data="$resource->contacts"
                :resource="$resource"
                :edit="Permission::can(UserPermission::USER, 'show')"
                :delete="Permission::can(UserPermission::USER, 'delete')"
            /> --}}
            <form
                method="post"
                action="{{ route('contact.user.update', [$contact, $user]) }}"
            >
                @csrf
                @method('PUT')

                <x-form.content.contact
                    identifier="user_edit"
                />

                <section class="mt-2">
                    <x-button
                        type="submit"
                    >Update contact</x-button>
                </section>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
