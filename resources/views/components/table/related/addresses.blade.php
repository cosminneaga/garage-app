@props(['data', 'resource'])

@php
    use App\Enums\UserPermission;

    $routeName = $resource->getTable();
@endphp

<x-bladewind.card class="overflow-auto">
    <x-slot:header>
        <div class="flex items-center justify-between p-4">
            <h4>ADDRESSES</h4>
            <x-bladewind.button onclick="showModal('modal-address-create')">
                Add address
            </x-bladewind.button>
        </div>
    </x-slot:header>

    <x-bladewind.table
        celled
        compact
    >
        <x-slot name="header">
            <th>Number</th>
            <th>Street</th>
            <th>Postcode</th>
            <th>Extra</th>
            <th>Actions</th>
        </x-slot>

        @foreach ($data as $address)
            <tr>
                <td>{{ $address->number }}</td>
                <td>{{ $address->street }}</td>
                <td>{{ $address->postcode }}</td>
                <td>{{ $address->extra }}</td>
                <td>
                    <div class="flex gap-1">
                        @can(UserPermission::name(UserPermission::ADDRESS, 'update'))
                            <a href="{{ route($routeName . '.address.edit', [$resource, $address]) }}">
                                <x-bladewind.button.circle
                                    icon="pencil"
                                    color="green"
                                    size="tiny"
                                    outline
                                />
                            </a>
                        @endcan
                        @can(UserPermission::name(UserPermission::ADDRESS, 'delete'))
                            <x-bladewind.button.circle
                                icon="trash"
                                color="red"
                                size="tiny"
                                outline
                                onclick="showModal('acdm-{{ $address->id }}')"
                            />

                            <form
                                id="acdf-{{ $address->id }}"
                                action="{{ route($routeName . '.address.destroy', [$resource, $address]) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                            </form>

                            <x-bladewind.modal
                                name="acdm-{{ $address->id }}"
                                type="warning"
                                ok_button_action="submitResourceDeleteForm('acdf-{{ $address->id }}')"
                            >
                                Are you sure you want to delete this address?
                            </x-bladewind.modal>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </x-bladewind.table>

    <x-modal.address.create
        name="modal-address-create"
        :resource="$resource"
    />
</x-bladewind.card>
