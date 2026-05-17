@php
    use App\Enums\UserPermission;
@endphp

<x-layout::index title="Team">
    <h1 class="text-2xl font-bold underline">USERS</h1>
    <br><br>

    <x-table.users
        :data="$users"
        chat
        :edit="Auth::user()->can(UserPermission::name(UserPermission::USER, 'update'))"
        :delete="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'delete'))"
    />
</x-layout::index>
