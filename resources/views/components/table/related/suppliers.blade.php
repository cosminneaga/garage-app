@props(['company'])

<x-bladewind.card class="overflow-auto">
    <x-slot:header>
        <div class="p-4 flex justify-between items-center">
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

        @foreach ($company->suppliers()->get() as $supplier)
            <tr>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->code }}</td>
                <td>{{ \App\Enums\SupplierType::getLabel($supplier->type) }}</td>
                <td>{{ $supplier->tax_id }}</td>
                <td>{{ $supplier->registration_number }}</td>
                <td>
                    <div class="flex gap-1">
                        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::SUPPLIER, 'show'))
                            <x-bladewind.button.circle
                                icon="eye"
                                color="primary"
                                size="tiny"
                                outline
                                onclick="location.href='/companies/{{ $company->id }}/suppliers/{{ $supplier->id }}'"
                            />
                        @endcan
                        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::SUPPLIER, 'delete'))
                            <form
                                action="{{ route('companies.supplier.destroy', [$company, $supplier]) }}"
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
        :company="$company"
    />
</x-bladewind.card>
