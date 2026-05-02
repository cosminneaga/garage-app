@props(['data', 'model'])

<?php
if ($model instanceof \App\Models\Company) {
    $routeName = 'companies';
} elseif ($model instanceof \App\Models\User) {
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
                        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::ADDRESS, 'show'))
                            <x-bladewind.button.circle
                                icon="eye"
                                color="primary"
                                size="tiny"
                                outline
                                onclick="location.href='/{{ $routeName }}/{{ $model->id }}/address/{{ $address->id }}'"
                            />
                        @endcan
                        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::ADDRESS, 'delete'))
                            <form
                                action="{{ route($routeName . '.address.destroy', [$model, $address]) }}"
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

    <x-modal.address.create
        name="modal-address-create"
        :resource="$model"
    />
</x-bladewind.card>
