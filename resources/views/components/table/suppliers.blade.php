@props([
    'suppliers' => [],
    'edit_action' => false,
    'delete_action' => false,
    'restore_action' => false,
])

@php
use \App\Enums\UserPermission;
@endphp

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
                    <a
                        class="underline"
                        href="{{ route('suppliers.show', $supplier) }}"
                    ><strong>{{ $supplier->name }}</strong></a>
                </div>
            </td>
            <td>{{ $supplier->code }}</td>
            <td>{{ $supplier->type }}</td>
            <td>{{ $supplier->tax_id }}</td>
            <td>{{ $supplier->registration_number }}</td>
            <td>
                <div class="flex gap-1">
                    @if ($edit_action)
                        @can(UserPermission::name(UserPermission::SUPPLIER, 'update'))
                            <x-bladewind.button.circle
                                icon="pencil-square"
                                color="primary"
                                size="tiny"
                                outline
                                onclick="location.href='/suppliers/{{ $supplier->id }}/edit'"
                            />
                        @endcan
                    @endif
                    @if ($delete_action)
                        @can(UserPermission::name(UserPermission::SUPPLIER, 'delete'))
                            <form
                                action="{{ route('suppliers.destroy', $supplier) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <x-bladewind.button.circle
                                    icon="trash"
                                    color="red"
                                    size="tiny"
                                    outline
                                    can_submit
                                />
                            </form>
                        @endcan
                    @endif
                    @if ($restore_action)
                        @can(UserPermission::name(UserPermission::SUPPLIER, 'restore'))
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
                        @endcan
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
</x-table>
