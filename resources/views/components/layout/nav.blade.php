<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-24 flex items-center justify-between">
        <div>

            <el-dropdown class="inline-block">
                <button
                    class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring-1 inset-ring-white/5 hover:bg-white/20"
                >
                    Menu
                    <svg
                        class="-mr-1 size-5 text-gray-400"
                        data-slot="icon"
                        aria-hidden="true"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd"
                            fill-rule="evenodd"
                        />
                    </svg>
                </button>

                <el-menu
                    class="w-56 origin-top-right divide-y divide-white/10 rounded-md bg-gray-800 outline-1 -outline-offset-1 outline-white/10 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in"
                    anchor="bottom end"
                    popover
                >
                    @can('company_show')
                        <div class="py-1">
                            <a
                                class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:text-white focus:outline-hidden"
                                href="/companies"
                            >My Companies</a>
                            @can('viewAll', 'company')
                                <a
                                    class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:text-white focus:outline-hidden"
                                    href="/companies/all"
                                >All Companies</a>
                            @endcan
                        </div>
                    @endcan
                </el-menu>
            </el-dropdown>

        </div>

        <div class="flex flex-col gap-2">
            @auth
                Hello, {{ Auth::user()->name }}
            @endauth

            <div class="flex gap-x-5 items-center">
                @auth
                    <form
                        action="/logout"
                        method="POST"
                    >
                        @csrf
                        <button
                            class="btn btn-outlined"
                            data-test="logout"
                            type="submit"
                        >Logout</button>
                    </form>
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
