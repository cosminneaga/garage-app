<x-layout::index title="Booking">
    {{-- @dd($bookings) --}}

    <x-table.bookings
        :data="$bookings"
        search_route="{{ route('bookings.companies.index', $company) }}"
        :edit="Permission::can(UserPermission::COMPANY, 'show')"
        :delete="Permission::can(UserPermission::COMPANY, 'delete')"
    />
</x-layout::index>
