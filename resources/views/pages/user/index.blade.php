@php
    use App\Enums\UserPermission;
@endphp

<x-layout::index title="Team">
    <x-table.users
        :data="$users"
        chat
        :edit="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'update'))"
        :delete="Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'delete'))"
    />
</x-layout::index>
