<x-layout::index title="List of users">
    <x-table.users
        :data="$users"
        chat
        edit
        delete
        searchRoute="{{ route('users.all') }}"
    />
</x-layout::index>
