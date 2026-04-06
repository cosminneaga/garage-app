<x-layout>
    <x-table :data="$companies">
        <x-slot:header>
            <th>ID</th>
            <th>Name</th>
            <th>Tax ID</th>
            <th>Registration Number</th>
            <th>Tax Value</th>
            <th>Invoice Prefix</th>
            <th>Actions</th>
        </x-slot:header>

        @foreach ($companies as $company)
            <tr>
                <td>{{ $company->id }}</td>
                <td>{{ $company->name }}</td>
                <td>{{ $company->tax_id }}</td>
                <td>{{ $company->registration_number }}</td>
                <td>{{ $company->tax_value }}</td>
                <td>{{ $company->invoice_prefix }}</td>
                {{-- <td class="flex gap-1">
                    <x-bladewind.button.circle
                        icon="pencil-square"
                        color="primary"
                        size="tiny"
                        outline
                        onclick="location.href='/users/{{ $user->id }}/edit'"
                    />
                    <form
                        action="{{ route('users.destroy', $user) }}"
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
                </td> --}}
            </tr>
        @endforeach
    </x-table>
</x-layout>
