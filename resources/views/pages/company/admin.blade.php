@php
use App\Enums\UserPermission;
@endphp

<x-layout title="Companies">

    <h1 class="text-2xl font-bold underline">COMPANIES</h1>
    <br><br>

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
                        <strong>{{ $company->name }}</strong>
                    </div>
                </td>
                <td>{{ $company->tax_id }}</td>
                <td>{{ $company->registration_number }}</td>
                <td>{{ $company->tax_value }}</td>
                <td>{{ $company->invoice_prefix }}</td>
                <td>
                    <div class="flex gap-1">

                        @can(UserPermission::name(UserPermission::COMPANY, 'update'))
                            @if (!$company->trashed())
                                <x-bladewind.button.circle
                                    icon="pencil-square"
                                    color="primary"
                                    size="tiny"
                                    outline
                                    onclick="location.href='{{ route('companies.edit', $company) }}'"
                                />
                            @endif
                        @endcan
                        @can(UserPermission::name(UserPermission::COMPANY, 'delete'))
                            @if (!$company->trashed())
                                <x-bladewind.button.circle
                                    icon="trash"
                                    color="red"
                                    size="tiny"
                                    outline
                                    onclick="showModal('ccdm-{{ $company->id }}')"
                                />

                                <form
                                    id="ccdf-{{ $company->id }}"
                                    action="{{ route('companies.destroy', $company) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <x-bladewind.modal
                                    name="ccdm-{{ $company->id }}"
                                    type="warning"
                                    ok_button_action="submitResourceDeleteForm('ccdf-{{ $company->id }}')"
                                >
                                    Are you sure you want to delete this company?
                                </x-bladewind.modal>
                            @endif
                        @endcan
                        @can(UserPermission::name(UserPermission::COMPANY, 'restore'))
                            @if ($company->trashed())
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
                            @endif
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach

    </x-table>

</x-layout>
