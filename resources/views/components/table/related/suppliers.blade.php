@props(['data', 'model'])

@php
    use App\Enums\SupplierType;
    use App\Enums\UserPermission;
@endphp

<x-bladewind.card class="overflow-auto">
    <x-slot:header>
        <div class="flex items-center justify-between p-4">
            <h4>SUPPLIERS</h4>
            <x-bladewind.button onclick="showModal('modal-supplier-create')">
                Add supplier
            </x-bladewind.button>
        </div>
    </x-slot:header>

    <x-bladewind.table>
        <x-slot name="header">
            <th>Name</th>
            <th>Code</th>
            <th>Type</th>
            <th>Tax ID</th>
            <th>Registration Number</th>
            <th>Actions</th>
        </x-slot>

        @foreach ($data as $supplier)
            <tr>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->code }}</td>
                <td>{{ SupplierType::getLabel($supplier->type) }}</td>
                <td>{{ $supplier->tax_id }}</td>
                <td>{{ $supplier->registration_number }}</td>
                <td>
                    <div class="flex gap-1">
                        @can(UserPermission::name(UserPermission::SUPPLIER, 'show'))
                            <x-bladewind.button.circle
                                icon="eye"
                                color="primary"
                                size="tiny"
                                outline
                                onclick="location.href='/companies/{{ $model->id }}/suppliers/{{ $supplier->id }}'"
                            />
                        @endcan
                        @can(UserPermission::name(UserPermission::SUPPLIER, 'delete'))
                            <form
                                action="{{ route('companies.supplier.destroy', [$model, $supplier]) }}"
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

    <x-modal.supplier.create
        name="modal-supplier-create"
        :company="$model"
    />
</x-bladewind.card>
