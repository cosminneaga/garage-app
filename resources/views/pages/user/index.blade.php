@php
    use App\Enums\UserPermission;
@endphp

<x-layout title="Team">
    <h1 class="text-2xl font-bold underline">USERS</h1>
    <br><br>

    <x-table.users
        :users="$users"
        message_action
        :edit_action="Auth::user()->can(UserPermission::name(UserPermission::USER, 'update'))"
        :delete_action="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'delete'))"
    />
</x-layout>
