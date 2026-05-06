@php
    use App\Enums\UserPermission;
@endphp

<x-layout title="Suppliers">

    <h1 class="text-2xl font-bold underline">SUPPLIERS</h1>
    <br><br>

    <x-table :data="$suppliers">
        <x-slot:header>
            <th>Name</th>
            <th>Code</th>
            <th>Type</th>
            <th>Tax ID</th>
            <th>Registration Number</th>
            <th>Actions</th>
        </x-slot:header>

        @foreach ($suppliers as $supplier)
            <tr>
                <td>
                    <div class="flex items-end gap-1">
                        <strong>{{ $supplier->name }}</strong>
                    </div>
                </td>
                <td>{{ $supplier->code }}</td>
                <td>{{ $supplier->type }}</td>
                <td>{{ $supplier->tax_id }}</td>
                <td>{{ $supplier->registration_number }}</td>
                <td>
                    <div class="flex gap-1">
                        @can(UserPermission::name(UserPermission::SUPPLIER, 'delete'))
                            @if (!$supplier->trashed())
                                <x-bladewind.button.circle
                                    icon="trash"
                                    color="red"
                                    size="tiny"
                                    outline
                                    onclick="showModal('scdm-{{ $supplier->id }}')"
                                />

                                <form
                                    id="scdf-{{ $supplier->id }}"
                                    action="{{ route('suppliers.destroy', $supplier) }}"
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
                            @endif
                        @endcan
                        @can(UserPermission::name(UserPermission::SUPPLIER, 'restore'))
                            @if ($supplier->trashed())
                                <form
                                    action="{{ route('suppliers.restore', $supplier) }}"
                                    method="POST"
                                >
                                    @csrf

                                    <x-bladewind.button.circle
                                        icon="arrow-left-start-on-rectangle"
                                        color="green"
                                        size="tiny"
                                        outline
                                        can_submit
                                    />
                                </form>
                            @endif
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>

</x-layout>
