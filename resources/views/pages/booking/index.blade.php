<x-layout::index title="Booking">
    {{-- @json($bookings) --}}

    <x-table.bookings :data="$bookings" />
</x-layout::index>
