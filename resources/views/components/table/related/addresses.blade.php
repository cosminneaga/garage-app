@props(['resource'])

<?php
if ($resource instanceof \App\Models\Company) {
    $routeName = 'companies';
} elseif ($resource instanceof \App\Models\User) {
    $routeName = 'users';
}
?>

<x-bladewind.card class="overflow-auto">
    <x-slot:header>
        <div class="p-4 flex justify-between items-center">
            <h4>ADDRESSES</h4>
            <x-bladewind.button onclick="showModal('modal-address-create')">
                Add address
            </x-bladewind.button>
        </div>
    </x-slot:header>

    <x-bladewind.table>
        <x-slot name="header">
            <th>Number</th>
            <th>Street</th>
            <th>Postcode</th>
            <th>Country</th>
            <th>Coordinates</th>
            <th>Extra</th>
            <th>Actions</th>
        </x-slot>

        @foreach ($resource->addresses()->get() as $address)
            <tr>
                <td>{{ $address->number }}</td>
                <td>{{ $address->street }}</td>
                <td>{{ $address->postcode }}</td>
                <td>{{ $address->country->name }}</td>
                <td>{{ implode(',', $address->coordinates) }}</td>
                <td>{{ $address->extra }}</td>
                <td>
                    @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::ADDRESS,
                        'delete'))
                        <form
                            action="{{ route($routeName . '.address.destroy', [$resource, $address]) }}"
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
                </td>
            </tr>
        @endforeach
    </x-bladewind.table>

    @if ($resource instanceof \App\Models\Company)
        <x-modal.company.address.create
            name="modal-address-create"
            :company="$resource"
        />
    @endif
</x-bladewind.card>
