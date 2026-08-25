@props([
    'unread_notifications' => 0,
])

@php
    $user = Auth::user();
@endphp

<div
    class="hidden bg-neutral-primary-medium border-default-medium rounded-base z-10 w-auto border px-2.5 py-2 shadow-lg"
    id="nav-dropdown-profile-menu"
>
    <div class="p-2">
        <div class="text-md">
            <div class="text-heading font-medium">{{ Auth::user()->name }}</div>
            <div class="text-body">{{ Auth::user()->email }}</div>
        </div>
    </div>
    <ul
        class="text-body p-2 text-sm font-medium"
        aria-labelledby="nav-dropdown-profile-btn"
    >

        <li>
            <p class="font-bold">Administrative</p>
        </li>
        @super
            <li>
                <a
                    class="hover:bg-neutral-tertiary-medium hover:text-heading inline-flex w-full items-center rounded p-2"
                    href="/pulse"
                    target="__blank"
                >Pulse</a>
            </li>
            <li>
                <a
                    class="hover:bg-neutral-tertiary-medium hover:text-heading inline-flex w-full items-center rounded p-2"
                    href="/telescope"
                    target="__blank"
                >Telescope</a>
            </li>
        @endsuper
        <li>
            <a
                class="hover:bg-neutral-tertiary-medium hover:text-heading inline-flex w-full items-center rounded p-2"
                href="{{ route('profile.users.edit', Auth::user()) }}"
            >Profile</a>
        </li>

        @if (count($unread_notifications) > 0)
            <!-- UNREAD NOTIFICATIONS -->
            <li>
                <li class="mb-2">
                    <p class="font-bold">Notifications</p>
                </li>
                <ul class="text-heading bg-neutral-primary-soft border-default rounded-base w-48 border text-sm font-medium">
                    @foreach ($unread_notifications as $notification)
                        <li class="border-default w-full border-b px-4 py-2">{{ $notification->data['title'] }}</li>
                    @endforeach
                </ul>

                <a
                    class="hover:bg-neutral-tertiary-medium hover:text-heading inline-flex w-full items-center rounded p-2"
                    href="{{ route('users.notifications') }}"
                >See all notifications</a>
            </li>
            <br>
        @endif

        <li>
            <form
                action="/logout"
                method="POST"
            >
                @csrf
                <button
                    class="bg-danger hover:bg-brand-strong focus:ring-brand-medium shadow-xs rounded-base box-border inline-flex items-center border border-transparent px-4 py-2.5 text-sm font-medium leading-5 text-white focus:outline-none focus:ring-4"
                    type="submit"
                >
                    <x-fwb-o-arrow-right-to-bracket />
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>

{{-- @json(Auth::user()->unreadNotifications) --}}
