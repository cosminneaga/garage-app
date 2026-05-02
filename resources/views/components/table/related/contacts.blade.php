@props(['data', 'model'])

<?php
if ($model instanceof \App\Models\Company) {
    $routeName = 'companies';
} elseif ($model instanceof \App\Models\User) {
    $routeName = 'users';
}
?>

<x-bladewind.card
    class="overflow-auto"
    title="Contacts"
>
    <x-slot:header>
        <div class="p-4 flex justify-between items-center">
            <h4>CONTACTS</h4>
            <x-bladewind.button onclick="showModal('modal-contact-create')">
                Add contact
            </x-bladewind.button>
        </div>
    </x-slot:header>

    <x-bladewind.table
        celled
        compact
        layout="custom"
    >
        <x-slot name="header">
            <th>Mobile</th>
            <th>Landline</th>
            <th>Email</th>
            <th>URL</th>
            <th>Info</th>
            <th>Actions</th>
        </x-slot>

        @foreach ($data as $contact)
            <tr>
                <td>{{ $contact->mobile }}</td>
                <td>{{ $contact->landline }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->url }}</td>
                <td>
                    <div class="w-75">
                        {!! $contact->info !!}
                    </div>
                </td>
                <td>
                    <div class="flex gap-1">
                        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::CONTACT, 'show'))
                            <x-bladewind.button.circle
                                icon="eye"
                                color="primary"
                                size="tiny"
                                outline
                                onclick="location.href='/{{ $routeName }}/{{ $model->id }}/contact/{{ $contact->id }}'"
                            />
                        @endcan
                        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::CONTACT, 'delete'))
                            <form
                                action="{{ route($routeName . '.contact.destroy', [$model, $contact]) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <x-bladewind.button.circle
                                    can_submit
                                    icon="trash"
                                    color="red"
                                    size="tiny"
                                    outline
                                />
                            </form>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </x-bladewind.table>

    {{-- <x-modal.contact.create
        name="modal-contact-create"
        :resource="$resource"
    /> --}}
</x-bladewind.card>
