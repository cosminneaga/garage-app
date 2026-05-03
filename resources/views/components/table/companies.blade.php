@props([
    'companies' => [],
    'edit_action' => false,
    'delete_action' => false,
    'restore_action' => false,
])

@php
    use App\Enums\UserPermission;
@endphp

<x-table :data="$companies">
    <x-slot:header>
        <th>Name</th>
        <th>Tax ID</th>
        <th>Registration Number</th>
        <th>Tax Value</th>
        <th>Invoice Prefix</th>
        <th>Actions</th>
    </x-slot:header>

    @foreach ($companies as $company)
        <tr>
            <td>
                <div class="flex items-end gap-1">
                    <x-bladewind.avatar
                        size="regular"
                        :image="$company->image_path && !Str::isUrl($company->image_path)
                            ? asset('storage/' . $company->image_path)
                            : $company->image_path"
                    />
                    <a
                        class="underline"
                        href="{{ route('companies.show', [
                            'company' => $company,
                            'tab' => 'details',
                        ]) }}"
                    ><strong>{{ $company->name }}</strong></a>
                </div>
            </td>
            <td>{{ $company->tax_id }}</td>
            <td>{{ $company->registration_number }}</td>
            <td>{{ $company->tax_value }}</td>
            <td>{{ $company->invoice_prefix }}</td>
            <td>
                <div class="flex gap-1">
                    @if ($edit_action)
                        @can(UserPermission::name(UserPermission::COMPANY, 'update'))
                            <x-bladewind.button.circle
                                icon="pencil-square"
                                color="primary"
                                size="tiny"
                                outline
                                onclick="location.href='/companies/{{ $company->id }}/edit'"
                            />
                        @endcan
                    @endif
                    @if ($delete_action)
                        @can(UserPermission::name(UserPermission::COMPANY, 'delete'))
                            <form
                                action="{{ route('companies.destroy', $company) }}"
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
                        @can(UserPermission::name(UserPermission::COMPANY, 'restore'))
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
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
</x-table>
