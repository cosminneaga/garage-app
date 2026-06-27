<x-layout::index title="List of users">
    <x-table.users
        :data="$users"
        searchRoute="{{ route('users.all') }}"
        chat
        edit
        delete
        restore
    />
</x-layout::index>
