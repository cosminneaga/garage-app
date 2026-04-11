<x-layout title="Removed Companies">
    <h1 class="text-2xl font-bold underline">REMOVED COMPANIES</h1>
    <br><br>

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
                <td><a
                        class="underline"
                        href="{{ route('companies.show', $company) }}"
                    >{{ $company->name }}</a>
                </td>
                <td>{{ $company->tax_id }}</td>
                <td>{{ $company->registration_number }}</td>
                <td>{{ $company->tax_value }}</td>
                <td>{{ $company->invoice_prefix }}</td>
                <td class="flex gap-1">
                    @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::COMPANY,
                        'restore'))
                        <form
                            action="{{ route('companies.restore', $company) }}"
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
                </td>
            </tr>
        @endforeach
    </x-table>
</x-layout>
