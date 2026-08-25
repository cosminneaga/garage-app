@php
    $notifications = Auth::user()->notifications;
@endphp

<x-layout::index title="All Notifications">
    <x-tabs :tabs="NotificationTabs::ui()">
        <div class="w-full p-6 bg-neutral-primary-soft border border-default rounded-base shadow-xs">
            <h5 class="text-xl font-semibold text-heading mb-6">All Notifications</h5>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-default">
                    @foreach ($notifications as $notification)
                        <li class="pb-4 sm:pb-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-heading truncate">
                                        {{ $notification->data['title'] }} | {{ $notification->id }} |
                                        {{ $notification->type }}
                                    </p>
                                    <p class="text-sm text-body truncate">
                                        {{ $notification->data['message'] }}
                                    </p>
                                    <a href="{{ $notification->data['url'] }}"
                                        class="text-sm text-orange truncate hover:underline underline-offset-6">
                                        Go to resource
                                    </a>

                                    @if ($notification->unread())
                                        <form action="{{ route('users.notifications.read', $notification->id) }}"
                                            method="post">
                                            @csrf

                                            <button type="submit" class="text-sm text-success truncate !hover:cursor">
                                                Mark as read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </x-tabs>
</x-layout::index>
