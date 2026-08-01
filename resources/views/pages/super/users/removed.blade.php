<x-layout::index title="Users">
    <x-table.users
        :data="$data"
        search_route="{{ route('super.users.removed') }}"
        prefix_route="super"
        restore
    />
</x-layout::index>
