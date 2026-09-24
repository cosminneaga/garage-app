@props(['workorder'])

<x-card :description="'Workorder number: ' . $workorder->number . ', ID: ' . $workorder->id">
    <p class="text-sm font-bold">Title: {{ $workorder->title }}</p>
    <p class="text-sm">Status: {{ $workorder->status->label() }}</p>
    <p class="text-sm">Completed At: {{ $workorder->completed_at }}</p>
    <p class="text-sm">In Progress At: {{ $workorder->in_progress_at }}</p>
    <p class="text-sm">In Pause At: {{ $workorder->in_pause_at }}</p>
    <p class="text-sm">Cancelled At: {{ $workorder->cancelled_at }}</p>
    <p class="text-sm">Created By: {{ $workorder->creator?->name }}</p>
    <p class="text-sm">Updated By: {{ $workorder->updater?->name }}</p>
    <p class="text-sm">Deleted By: {{ $workorder->deletor?->name }}</p>
</x-card>
