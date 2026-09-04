@php
    $notifications = Auth::user()->readNotifications;
@endphp

<x-layout::index title="Read Notifications">
    <x-tabs :tabs="NotificationTabs::ui()">
        <div
            class="bg-neutral-primary-soft border-default rounded-base shadow-xs w-full border p-6">
            <h5 class="text-heading mb-6 text-xl font-semibold">Read
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
                                    <a
                                        href="{{ $notification->data['url'] }}"
                                        class="text-orange underline-offset-6 truncate text-sm hover:underline"
                                    >
                                        Go to resource
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </x-tabs>
</x-layout::index>
