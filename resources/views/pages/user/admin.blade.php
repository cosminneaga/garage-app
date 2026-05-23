@php
    use App\Enums\UserPermission;
@endphp

<x-layout::index title="Team">
    <h1 class="text-2xl font-bold underline">USERS</h1>
    <br>

    <x-table.users
        :data="$users"
        chat
        edit
        delete
        searchRoute="{{ route('users.all') }}"
    />
</x-layout::index>
