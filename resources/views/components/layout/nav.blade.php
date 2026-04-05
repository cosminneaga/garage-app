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

                    @role('admin_super')
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
                                <a href="/users" class="w-full">List</a>
                            </x-bladewind.dropmenu.item>
                            <x-bladewind.dropmenu.item icon="folder-plus">
                                <a href="/users/create" class="w-full">Create</a>
                            </x-bladewind.dropmenu.item>
                        </x-bladewind.dropmenu>
                    @endrole

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

                            <x-bladewind.dropmenu.item divider />

                            @role('admin_super')
                                <x-bladewind.dropmenu.item header="true">
                                    <h3 class="font-bold">Application Administration</h3>
                                </x-bladewind.dropmenu.item>

                                <x-bladewind.dropmenu.item icon="building-office">
                                    <a
                                        class="w-full"
                                        href="/companies/all"
                                    >Companies</a>
                                </x-bladewind.dropmenu.item>
                            @endrole
                        @endcan
                    </x-bladewind.dropmenu>
                @endauth
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <div class="flex gap-x-5 items-center">
                @auth
                    <x-bladewind::dropmenu>
                        <x-slot:trigger>
                            <div class="flex items-center">
                                <div class="grow">
                                    <x-bladewind::avatar
                                        class="rounded-round"
                                        size="regular"
                                        show_ring="false"
                                        image="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                    />
                                </div>
                                <div class="border-2 border-white p-1 rounded-full">
                                    <x-bladewind::icon
                                        name="bars-3"
                                        type="solid"
                                        class="text-amber-400 h-8 w-8"
                                    />
                                </div>
                            </div>
                        </x-slot:trigger>

                        <x-bladewind::dropmenu.item>
                            <div class="grow">
                                <div><strong>{{ Auth::user()->name }}</strong></div>
                                <div class="text-sm">{{ Auth::user()->email }}</div>
                            </div>
                        </x-bladewind::dropmenu.item>

                        <x-bladewind::dropmenu.item divider />

                        <x-bladewind::dropmenu.item hover="false">
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
                        </x-bladewind::dropmenu.item>
                    </x-bladewind::dropmenu>
                @endauth

                @guest
                    <a href="/login">Login</a>
                    <a
                        class="btn"
                        href="/register"
                    >Register</a>
                @endguest
            </div>
        </div>
    </div>
</nav>
