@php
    $user = Auth::user();
@endphp

<nav class="border-border border-b px-6">
    <div class="mx-auto flex h-24 max-w-7xl items-center justify-between">
        <div>
            <div class="flex items-center gap-4">
                @auth
                    <button
                        class="hover:cursor-pointer"
                        data-drawer-target="app-drawer"
                        data-drawer-show="app-drawer"
                        type="button"
                        aria-controls="app-drawer"
                    >
                        <x-fwb-o-bars class="h-8 w-8 text-gray-600" />
                    </button>
                @endauth
                <x-navigation::drawer />

                <a href="/">
                    <img
                        class="h-auto w-20 rounded-sm"
                        src="{{ asset('logo-4x3.webp') }}"
                        title="GarageApp Logo"
                        alt="GarageApp Logo"
                    />
                </a>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-x-5">
                @auth
                    <button
                        class="flex items-center gap-2 hover:cursor-pointer"
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
                        <x-fwb-o-adjustments-horizontal
                            class="h-8 w-8 text-gray-500"
                        />
                    </button>
                    <x-navigation::user-dropdown />

                    <!-- NOTIFICATION -->
                    <button id="notification-button">
                        🔔
                        <span id="notification-count">0</span>
                    </button>

                    <div id="notifications"></div>
                @endauth

                @guest
                    <div
                        class="border-b-0! hover:border-b-4! hover:border-t-4! border-primary-500 px-2 transition-all delay-150 duration-100 ease-in-out">
                        <a href="/login">Login</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
