@php
    use App\Enums\UserPermission;
@endphp

<x-layout::index title="Removed Team Members">
    <h1 class="text-2xl font-bold underline">REMOVED TEAM MEMBERS</h1>
    <br><br>

    <x-table.users
        :data="$users"
        :restore="Auth::user()->can(UserPermission::name(UserPermission::USER, 'restore'))"
    />
</x-layout::index>
