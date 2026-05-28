@php
    use App\Enums\UserPermission;
@endphp

<x-layout::index title="Removed Team Members">
    <x-table.users
        :data="$users"
        :restore="Auth::user()->can(UserPermission::name(UserPermission::USER, 'restore'))"
    />
</x-layout::index>
