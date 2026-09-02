@php
    $user = Auth::user();
    $unreadNotifications = $user
        ? $user->unreadNotifications()->latest()->take(3)->get()
        : [];
@endphp

<button
    class="relative flex items-center gap-2 hover:cursor-pointer"
    id="nav-dropdown-profile-btn"
    data-dropdown-toggle="nav-dropdown-profile-menu"
    data-dropdown-trigger="click"
    type="button"
>
    <img
        class="ring-default h-15 w-15 rounded-full object-cover p-1 ring-2"
        src="{{ !Str::isUrl($user->image_path) ? asset('storage/' . $user->image_path) : $user->image_path }}"
        alt="User avatar"
    />

    <!-- NOTIFICATION INDICATOR -->
    <span
        class="bg-success absolute right-2 top-0 me-0 h-4 w-4 rounded-full"
        x-data
        x-show="$store.notification.indicator_show"
    ></span>
</button>

<div
    class="bg-neutral-primary-medium border-default-medium rounded-base z-10 hidden w-auto border px-2.5 py-2 shadow-lg"
    id="nav-dropdown-profile-menu"
>
    <div class="p-2">
        <div class="text-md">
            <div class="text-heading font-medium">{{ $user->name }}</div>
            <div class="text-body">{{ $user->email }}</div>
        </div>
    </div>
    <ul
        class="text-body p-2 text-sm font-medium"
        aria-labelledby="nav-dropdown-profile-btn"
    >
        <div>
            <strong>Administrative</strong>
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
                    href="{{ route('profile.users.edit', $user) }}"
                >Profile</a>
            </li>
            <br>
        </div>

        @auth
            <div
                x-data
                x-show="$store.notification.list_show"
            >
                <strong>Notifications</strong>

                <ul
                    x-data
                    class="text-heading bg-neutral-primary-soft border-default rounded-base w-48 border text-sm font-medium"
                >
                    <template
                        x-for="notification in $store.notification.data"
                        :key="notification.id"
                    >
                        <li class="border-default w-full border-b px-4 py-2">
                            <span x-text="notification.title"></span>
                        </li>
                    </template>
                </ul>

                <a
                    class="hover:bg-neutral-tertiary-medium hover:text-heading inline-flex w-full items-center rounded p-2"
                    href="{{ route('users.notifications') }}"
                >See all notifications</a>
                <br>
            </div>
        @endauth

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

@auth
    <script type="module">
        const unreadNotifications = @json($unreadNotifications);
        const userId = {{ Auth::user()->id }};
        const store = Alpine.store("notification");

        Echo.private(`App.Models.User.${userId}`).notification((notification) => {
            console.log('Notification received:', notification);

            store.showList();
            store.showIndicator();
            if (store.data.length < 3) {
                store.data.push(notification);
            }
        });


        if (unreadNotifications.length > 0) {
            store.showList();
            store.showIndicator();
            store.data = unreadNotifications.map((notification) => notification
                .data);
        }
    </script>
@endauth
