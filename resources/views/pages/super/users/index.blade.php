<x-layout::index title="List of all users">
    <x-table.users
        :data="$data"
        search_route="{{ route('super.users.all') }}"
        chat
        edit
        delete
    />
</x-layout::index>
