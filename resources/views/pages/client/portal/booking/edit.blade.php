@php
    Session::flashInput((array) $booking);
@endphp

<x-layout::client title="Booking Edit">
    {{-- @json($booking) --}}
    <x-card title="Booking: {{ $booking->number }}">

        @if (count($booking->clientFiles))
            <x-gallery.files :files="$booking->clientFiles" />
        @endif

        <form
            action="{{ route('clients.bookings.update', $booking->id) }}"
            method="POST"
            enctype="@enctype"
        >
            @csrf
            @method('PUT')

            <section class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <x-form.field.textarea
                    identifier="client_portal"
                    name="client_notes"
                    label="Notes"
                    value="{{ old('client_notes', '') }}"
                />
                <x-form.field.textarea
                    identifier="client_portal"
                    name="complaint"
                    label="Complaint"
                    value="{{ old('complaint', '') }}"
                />
            </section>
            <x-form.field.file
                identifier="client_portal"
                name="files[]"
                max_files="5"
                accepted_files="{{ FileFormatType::mergeForm([FileFormatType::IMAGE, FileFormatType::DOCUMENT]) }}"
                label="Media"
            />

            <section class="mt-4">
                <x-button type="submit">Submit</x-button>
            </section>
        </form>

    </x-card>
</x-layout::client>
