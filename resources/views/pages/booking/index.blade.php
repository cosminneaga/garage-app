<x-layout::index title="Booking">
    {{-- @dd($bookings) --}}

    <x-table.bookings
        :data="$bookings"
        search_route="{{ route('bookings.index') }}"
        :edit="Permission::can(UserPermission::BOOKING, 'show')"
        :delete="Permission::can(UserPermission::BOOKING, 'delete')"
    />
</x-layout::index>
