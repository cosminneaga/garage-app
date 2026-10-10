<x-layout::client title="Client Portal">
    <h1 class="text-2xl font-bold">Hello, {{ Auth::user()->name }}</h1>

    <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
        <x-card title="Bookings">
            <x-table.bookings
                :data="$bookings"
                edit
                :edit_route="fn($row) => route('clients.bookings.edit', $row)"
            />
        </x-card>

        <x-card title="Workorders">
            <x-table.workorders :data="$workorders" />
        </x-card>

        <x-card title="Contact Information">
            <x-table.related.contacts
                :data="$contacts"
                :resource="Auth::user()"
            />
        </x-card>

        <x-card title="Address Information">
            <x-table.related.addresses
                :data="$addresses"
                :resource="Auth::user()"
                :countries="$countries"
            />
        </x-card>
    </div>
</x-layout::client>
