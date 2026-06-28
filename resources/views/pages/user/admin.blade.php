<x-layout::index title="List of users">
    <x-table.users
        :data="$users"
        chat
        edit
        delete
        restore
        searchRoute="{{ route('users.all') }}"
    />
</x-layout::index>
