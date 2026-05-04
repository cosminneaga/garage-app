@props(['data', 'model', 'actions' => true])

@php
    use App\Enums\UserPermission;

    if ($model instanceof \App\Models\Company) {
        $routeName = 'companies';
    } elseif ($model instanceof \App\Models\User) {
        $routeName = 'users';
    } elseif ($model instanceof \App\Models\Supplier) {
        $routeName = 'suppliers';
    }
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
            @if ($actions)
                <th>Actions</th>
            @endif
        </x-slot>

        @foreach ($data as $address)
            <tr>
                <td>{{ $address->number }}</td>
                <td>{{ $address->street }}</td>
                <td>{{ $address->postcode }}</td>
                <td>{{ $address->extra }}</td>
                @if ($actions)
                    <td>
                        <div class="flex gap-1">
                            @can(UserPermission::name(UserPermission::ADDRESS, 'update'))
                                <a href="{{ route($routeName . '.address.edit', [$model, $address]) }}">
                                    <x-bladewind.button.circle
                                        icon="pencil"
                                        color="green"
                                        size="tiny"
                                        outline
                                    />
                                </a>
                            @endcan
                            @can(UserPermission::name(UserPermission::ADDRESS, 'delete'))
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
                @endif
            </tr>
        @endforeach
    </x-bladewind.table>

    <x-modal.address.create
        name="modal-address-create"
        :resource="$model"
    />
</x-bladewind.card>
