@php
    $notifications = Auth::user()->unreadNotifications;
@endphp

<x-layout::index title="Unread Notifications">
    <x-tabs :tabs="NotificationTabs::ui()">
        <div
            class="bg-neutral-primary-soft border-default rounded-base shadow-xs w-full border p-6">
            <h5 class="text-heading mb-6 text-xl font-semibold">Unread
                Notifications</h5>
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
                                        {{ $notification->data['title'] }}</p>
                                    <span
                                        class="text-xs">{{ $notification->id }}
                                        |
                                        {{ $notification->data['type'] }}</span>
                                    <p class="text-body truncate text-sm">
                                        {{ $notification->data['message'] }}</p>

                                    <div>
                                        <a
                                            href="{{ $notification->data['url'] }}"
                                            class="text-orange hover:border-orange truncate border border-transparent pr-2 text-sm"
                                            target="_blank"
                                        >
                                            Go to resource
                                        </a>
                                        <form
                                            action="{{ route('users.notifications.read', $notification->id) }}"
                                            method="post"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="text-success hover:border-success !hover:pointer truncate border border-transparent pr-2 text-sm"
                                            >
                                                Mark as read
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </x-tabs>
</x-layout::index>
