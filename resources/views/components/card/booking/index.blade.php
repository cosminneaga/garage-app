@props(['booking'])

<x-card :description="'Booking number: ' . $booking->number . ', ID: ' . $booking->id">
    <p class="text-sm">Status: {{ $booking->status->label() }}</p>
    <p class="text-sm">Client Token: {{ $booking->client_url_token }}</p>
    <p class="text-sm">Completed At: {{ $booking->completed_at }}</p>
    <p class="text-sm">In Progress At: {{ $booking->in_progress_at }}</p>
    <p class="text-sm">In Review At: {{ $booking->in_review_at }}</p>
    <p class="text-sm">Cancelled At: {{ $booking->cancelled_at }}</p>
    <p class="text-sm">Reminder Sent At: {{ $booking->reminder_sent_at }}</p>
    <p class="text-sm">Created By: {{ $booking->creator?->name }}</p>
    <p class="text-sm">Updated By: {{ $booking->updater?->name }}</p>
    <p class="text-sm">Deleted By: {{ $booking->deletor?->name }}</p>
</x-card>
