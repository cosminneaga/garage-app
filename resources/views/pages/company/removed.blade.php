@php
use App\Enums\UserPermission;
@endphp

<x-layout title="Removed Companies">
    <h1 class="text-2xl font-bold underline">REMOVED COMPANIES</h1>
    <br><br>

    <x-table.companies
        :companies="$companies"
        :restore_action="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'restore'))"
    />
</x-layout>
