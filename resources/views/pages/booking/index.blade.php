<x-layout::index title="Booking">
    {{-- @dd($bookings) --}}

    <x-table.bookings
        :data="$bookings"
        search_route="{{ route('bookings.index') }}"
        :edit="Permission::can(UserPermission::BOOKING, 'show')"
        :edit_route="fn ($row) => route('bookings.companies.edit', [$row->id, $row->company_id])"
    />
</x-layout::index>
