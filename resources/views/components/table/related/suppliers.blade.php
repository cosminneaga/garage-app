@props(['data', 'resource'])

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
                        @can(UserPermission::name(UserPermission::SUPPLIER, 'update'))
                            <a href="{{route('companies.supplier.edit', [$resource, $supplier])}}">
                                <x-bladewind.button.circle
                                    icon="pencil"
                                    color="green"
                                    size="tiny"
                                    outline
                                />
                            </a>
                        @endcan
                        @can(UserPermission::name(UserPermission::SUPPLIER, 'delete'))
                            <x-bladewind.button.circle
                                icon="trash"
                                color="red"
                                size="tiny"
                                outline
                                onclick="showModal('scdm-{{ $supplier->id }}')"
                            />

                            <form
                                id="scdf-{{ $supplier->id }}"
                                action="{{ route('companies.supplier.destroy', [$resource, $supplier]) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                            </form>

                            <x-bladewind.modal
                                name="scdm-{{ $supplier->id }}"
                                type="warning"
                                ok_button_action="submitResourceDeleteForm('scdf-{{ $supplier->id }}')"
                            >
                                Are you sure you want to delete this supplier?
                            </x-bladewind.modal>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </x-bladewind.table>

    <x-modal.supplier.create
        name="modal-supplier-create"
        :company="$resource"
    />
</x-bladewind.card>
