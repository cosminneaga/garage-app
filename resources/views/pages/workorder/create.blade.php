<x-layout::index title="Workorder Create">
    <x-card>
        <x-card :description="'Booking number: ' . $booking->number . ', ID: ' . $booking->id">
            <p class="text-sm">Status: {{ $booking->status->label() }}</p>
            <p class="text-sm">Client Token: {{ $booking->client_url_token }}</p>
            @if ($booking->completed_at)
                <p class="text-sm">Completed At: {{ $booking->completed_at }}</p>
            @endif
            @if ($booking->in_progress_at)
                <p class="text-sm">In Progress At: {{ $booking->in_progress_at }}</p>
            @endif
            @if ($booking->in_review_at)
                <p class="text-sm">In Review At: {{ $booking->in_review_at }}</p>
            @endif
            @if ($booking->cancelled_at)
                <p class="text-sm">Cancelled At: {{ $booking->cancelled_at }}</p>
            @endif
            @if ($booking->reminder_sent_at)
                <p class="text-sm">Reminder Sent At: {{ $booking->reminder_sent_at }}</p>
            @endif
        </x-card>

        <form action="{{ route('workorders.bookings.store', $booking) }}" method="post">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <section>
                    <x-form.field.text
                        name="title"
                        value="Oil Change (JobName Enum)"
                        label="Title"
                    />
                    <x-form.field.text
                        name="labour_price_hourly"
                        type="number"
                        label="Labour Price Hourly"
                    />
                    <x-form.field.select
                        name="technician_id"
                        label="Assign technician"
                        :options="$technicians"
                        select_map_value="id"
                        :select_map_label="['name', 'email']"
                    />
                </section>
                <section>
                    <x-form.field.textarea
                        name="notes"
                        label="General notes"
                        rows="5"
                    />
                    <x-form.field.textarea
                        name="part_notes"
                        label="Part notes"
                        rows="5"
                    />
                </section>
            </div>

            <div class="mt-4">
                <x-button type="submit">Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
