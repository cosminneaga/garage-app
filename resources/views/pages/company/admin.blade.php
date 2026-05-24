@php
use App\Enums\UserPermission;
@endphp

<x-layout::index title="Companies">

    <x-table.companies
        :data="$companies"
        :edit="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'update'))"
        :delete="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'delete'))"
        :restore="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'restore'))"
    />
</x-layout::index>
