<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-24 flex items-center justify-between">
        <div>
            <div class="flex gap-2 items-center">
                @auth
                    <a href="/">
                        <x-bladewind.button.circle
                            type="secondary"
                            size="tiny"
                            outline
                            icon="home"
                            color="fucshie"
                        />
                    </a>


                    <x-bladewind.dropmenu position="left">
                        <x-slot:trigger>

                            <x-bladewind.button
                                type="secondary"
                                size="tiny"
                                outline
                            >
                                Users
                            </x-bladewind.button>
                        </x-slot:trigger>

                        <x-bladewind.dropmenu.item icon="users">
                            <a
                                class="w-full"
                                href="/users"
                            >Team</a>
                        </x-bladewind.dropmenu.item>
                        <x-bladewind.dropmenu.item icon="folder-plus">
                            <a
                                class="w-full"
                                href="/users/create"
                            >Create</a>
                        </x-bladewind.dropmenu.item>
                    </x-bladewind.dropmenu>

                    <x-bladewind.dropmenu position="left">
                        <x-slot:trigger>
                            <x-bladewind.button
                                type="secondary"
                                size="tiny"
                                outline
                            >
                                Companies
                            </x-bladewind.button>
                        </x-slot:trigger>


                        @can('company-show')
                            <x-bladewind.dropmenu.item icon="building-office">
                                <a
                                    class="w-full"
                                    href="/companies"
                                >List</a>
                            </x-bladewind.dropmenu.item>
                            <x-bladewind.dropmenu.item icon="folder-plus">
                                <a
                                    class="w-full"
                                    href="/companies/create"
                                >Create</a>
                            </x-bladewind.dropmenu.item>

                            @role('super')
                            @endrole
                        @endcan
                    </x-bladewind.dropmenu>
                @endauth
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <div class="flex gap-x-5 items-center">
                @auth
                    <x-bladewind.dropmenu>
                        <x-slot:trigger>
                            <div class="flex items-center">
                                <div class="grow">
                                    <x-bladewind.avatar
                                        class="rounded-full"
                                        size="regular"
                                        show_ring="false"
                                        image="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                    />
                                </div>
                                <div class="border-2 border-white p-1">
                                    <x-bladewind.icon
                                        class="text-amber-400 h-8 w-8"
                                        name="bars-3"
                                        type="solid"
                                    />
                                </div>
                            </div>
                        </x-slot:trigger>

                        <x-bladewind.dropmenu.item>
                            <div class="grow">
                                <div><strong>{{ Auth::user()->name }}</strong></div>
                                <div class="text-sm">{{ Auth::user()->email }}</div>
                            </div>
                        </x-bladewind.dropmenu.item>

                        @role('super')
                            <x-bladewind.dropmenu.item header="true">
                                <p class="font-bold">Administrative</p>
                            </x-bladewind.dropmenu.item>
                            <x-bladewind.dropmenu.item icon="building-office">
                                <a
                                    class="w-full"
                                    href="/users/all"
                                >Users</a>
                            </x-bladewind.dropmenu.item>
                            <x-bladewind.dropmenu.item icon="building-office">
                                <a
                                    class="w-full"
                                    href="/companies/all"
                                >Companies</a>
                            </x-bladewind.dropmenu.item>
                            <x-bladewind.dropmenu.item icon="building-office">
                                <a
                                    class="w-full"
                                    href="/pulse"
                                    target="__blank"
                                >Pulse</a>
                            </x-bladewind.dropmenu.item>
                            <x-bladewind.dropmenu.item icon="building-office">
                                <a
                                    class="w-full"
                                    href="/telescope"
                                    target="__blank"
                                >Telescope</a>
                            </x-bladewind.dropmenu.item>
                        @endrole


                        <x-bladewind.dropmenu.item hover="false">
                            <form
                                action="/logout"
                                method="POST"
                            >
                                @csrf
                                <x-bladewind::button
                                    class="w-full"
                                    color="red"
                                    radius="small"
                                    size="small"
                                    can_submit
                                >
                                    Logout
                                </x-bladewind::button>


                            </form>
                        </x-bladewind.dropmenu.item>
                    </x-bladewind.dropmenu>
                @endauth

                @guest
                    <div
                        class="px-2 border-b-0! border-primary-500 transition-all ease-in-out delay-150 duration-100 hover:border-b-4! hover:border-t-4!">
                        <a href="/login">Login</a>
                        {{-- <div class="border-b border-4 transition-all ease-in-out delay-150 duration-200 w-1 hover:w-full"></div> --}}
                    </div>
                    <div class="px-2 border-b-0! border-primary-500 transition-all ease-in-out delay-150 duration-100 hover:border-b-4! hover:border-t-4!">
                        <a href="/register">Register</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
