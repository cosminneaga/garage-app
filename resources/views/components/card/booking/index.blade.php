@props(['booking'])

<x-card :description="'Booking number: ' . $booking->number . ', ID: ' . $booking->id">
    <p class="text-sm"><b>Status:</b> {{ $booking->status->label() }}</p>
    <p class="text-sm"><b>Client Token:</b> {{ $booking->client_url_token }}</p>
    <p class="text-sm"><b>Completed At:</b> {{ $booking->completed_at }}</p>
    <p class="text-sm"><b>In Progress At:</b> {{ $booking->in_progress_at }}</p>
    <p class="text-sm"><b>In Review At:</b> {{ $booking->in_review_at }}</p>
    <p class="text-sm"><b>Cancelled At:</b> {{ $booking->cancelled_at }}</p>
    <p class="text-sm"><b>Reminder Sent At:</b> {{ $booking->reminder_sent_at }}</p>
    <p class="text-sm"><b>Created By:</b> {{ $booking->creator?->name }}</p>
    <p class="text-sm"><b>Updated By:</b> {{ $booking->updater?->name }}</p>
    <p class="text-sm"><b>Deleted By:</b> {{ $booking->deletor?->name }}</p>
</x-card>
