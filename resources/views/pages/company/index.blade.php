@php
    use App\Enums\UserPermission;
@endphp

<x-layout title="Companies">
    <x-table.companies
        :companies="$companies"
        :edit_action="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'update'))"
        :delete_action="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'delete'))"
    />
</x-layout>
