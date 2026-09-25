@props(['workorder'])

<x-card :description="'Workorder number: ' . $workorder->number . ', ID: ' . $workorder->id">
    <p class="text-sm font-bold"><b>Title:</b> {{ $workorder->title }}</p>
    <p class="text-sm"><b>Status:</b> {{ $workorder->status->label() }}</p>
    <p class="text-sm"><b>Completed At:</b> {{ $workorder->completed_at }}</p>
    <p class="text-sm"><b>In Progress At:</b> {{ $workorder->in_progress_at }}</p>
    <p class="text-sm"><b>In Pause At:</b> {{ $workorder->in_pause_at }}</p>
    <p class="text-sm"><b>Cancelled At:</b> {{ $workorder->cancelled_at }}</p>
    <p class="text-sm"><b>Created By:</b> {{ $workorder->creator?->name }}</p>
    <p class="text-sm"><b>Updated By:</b> {{ $workorder->updater?->name }}</p>
    <p class="text-sm"><b>Deleted By:</b> {{ $workorder->deletor?->name }}</p>
</x-card>
