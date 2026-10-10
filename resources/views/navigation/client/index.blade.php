<nav class="border-border border-b px-2 pb-2 lg:px-6">
    <div class="mx-auto flex items-center justify-between">
        <div>
            <div class="flex items-center gap-4">
                <a href="/client">
                    <img
                        class="h-auto w-20 rounded-sm"
                        src="{{ asset('logo-4x3.webp') }}"
                        title="GarageApp Logo"
                        alt="GarageApp Logo">
                </a>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-x-5">
                @auth('client')
                    <x-navigation::client.dropdown />
                @endauth

                @guest('client')
                    <div
                        class="border-b-0! hover:border-b-4! hover:border-t-4! border-primary-500 px-2 transition-all delay-150 duration-100 ease-in-out">
                        <a href="/login">User Portal</a>
                    </div>
                    <div
                        class="border-b-0! hover:border-b-4! hover:border-t-4! border-primary-500 px-2 transition-all delay-150 duration-100 ease-in-out">
                        <a href="/client/login">Login</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
