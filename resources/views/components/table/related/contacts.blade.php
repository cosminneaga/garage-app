@props(['data', 'resource'])

@php
    use App\Enums\UserPermission;

    $routeName = $resource->getTable();
@endphp

<x-bladewind.card
    class="overflow-auto"
    title="Contacts"
>
    <x-slot:header>
        <div class="flex items-center justify-between p-4">
            <h4>CONTACTS</h4>
            <x-bladewind.button onclick="showModal('modal-contact-create')">
                Add contact
            </x-bladewind.button>
        </div>
    </x-slot:header>

    <x-bladewind.table
        celled
        compact
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
                        @can(UserPermission::name(UserPermission::CONTACT, 'update'))
                            <a href="{{ route($routeName . '.contact.edit', [$resource, $contact]) }}">
                                <x-bladewind.button.circle
                                    icon="pencil"
                                    color="green"
                                    size="tiny"
                                    outline
                                />
                            </a>
                        @endcan
                        @can(UserPermission::name(UserPermission::CONTACT, 'delete'))
                            <x-bladewind.button.circle
                                icon="trash"
                                color="red"
                                size="tiny"
                                outline
                                onclick="showModal('cocdm-{{ $contact->id }}')"
                            />

                            <form
                                id="cocdf-{{ $contact->id }}"
                                action="{{ route($routeName . '.contact.destroy', [$resource, $contact]) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                            </form>

                            <x-bladewind.modal
                                name="cocdm-{{ $contact->id }}"
                                type="warning"
                                ok_button_action="submitResourceDeleteForm('cocdf-{{ $contact->id }}')"
                            >
                                Are you sure you want to delete this contact?
                            </x-bladewind.modal>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </x-bladewind.table>

    <x-modal.contact.create
        name="modal-contact-create"
        :resource="$resource"
    />
</x-bladewind.card>
