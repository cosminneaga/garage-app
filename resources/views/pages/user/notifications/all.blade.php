@php
    $notifications = Auth::user()->notifications;
@endphp

<x-layout::index title="All Notifications">
    <x-tabs :tabs="NotificationTabs::ui()">
        <div
            class="bg-neutral-primary-soft border-default rounded-base shadow-xs w-full border p-6">
            <h5 class="text-heading mb-6 text-xl font-semibold">All Notifications
            </h5>
            <div class="flow-root">
                <ul
                    role="list"
                    class="divide-default divide-y"
                >
                    @foreach ($notifications as $notification)
                        <li class="pb-4 sm:pb-4">
                            <div class="flex items-center gap-2">
                                <div class="min-w-0 flex-1">
                                    <p class="text-heading truncate font-medium">
                                        {{ $notification->data['title'] }} |
                                        {{ $notification->id }} |
                                        {{ $notification->type }}
                                    </p>
                                    <p class="text-body truncate text-sm">
                                        {{ $notification->data['message'] }}
                                    </p>
                                    <a
                                        href="{{ $notification->data['url'] }}"
                                        class="text-orange underline-offset-6 truncate text-sm hover:underline"
                                    >
                                        Go to resource
                                    </a>

                                    @if ($notification->unread())
                                        <form
                                            action="{{ route('users.notifications.read', $notification->id) }}"
                                            method="post"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="text-success !hover:cursor truncate text-sm"
                                            >
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
