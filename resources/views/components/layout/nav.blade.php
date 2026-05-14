@php
    use App\Enums\UserPermission;

    $user = Auth::user();
@endphp

<nav class="border-border border-b px-6">
    <div class="mx-auto flex h-24 max-w-7xl items-center justify-between">
        <div>
            <div class="flex items-center gap-4">

                @auth
                    <button
                        data-drawer-target="app-drawer"
                        data-drawer-show="app-drawer"
                        type="button"
                        aria-controls="app-drawer"
                    >
                        <x-fwb-o-bars class="h-8 w-8 text-gray-600" />
                    </button>
                @endauth
                <div
                    class="bg-neutral-primary-soft border-default text-heading fixed left-0 top-0 z-40 h-screen w-96 -translate-x-full overflow-y-auto border-e p-4 transition-transform"
                    id="app-drawer"
                    aria-labelledby="drawer-label"
                    tabindex="-1"
                >

                    <div class="pb-4 flex items-end gap-2">
                        <img
                            class="h-auto w-20 rounded-sm"
                            src="{{ asset('logo-4x3.webp') }}"
                            title="GarageApp Logo"
                            alt="GarageApp Logo"
                        />
                        <span class="text-heading self-center whitespace-nowrap text-lg font-semibold">Garage App</span>
                    </div>

                    <br>
                    <div class="border-default border-b">
                        <span class="text-heading">Users</span>
                    </div>
                    <ul class="space-y-2 font-medium">
                        @can(UserPermission::name(UserPermission::USER, 'show'))
                            <li class="my-2">
                                <a
                                    class="w-full"
                                    href="/users?limit=10"
                                >
                                    Team
                                </a>
                            </li>
                            @can(UserPermission::name(UserPermission::USER, 'store'))
                                <li class="my-2">
                                    <a
                                        class="w-full"
                                        href="/users/create"
                                    >
                                        Create
                                    </a>
                                </li>
                            @endcan
                            @can(UserPermission::name(UserPermission::USER, 'restore'))
                                <li class="my-2">
                                    <a
                                        class="w-full"
                                        href="/users/restore?limit=10"
                                    >
                                        Removed
                                    </a>
                                </li>
                            @endcan
                        @endcan
                    </ul>


                    <br>
                    <div class="border-default border-b">
                        <span class="text-heading">Companies</span>
                    </div>
                    <ul class="space-y-2 font-medium">
                        @can(UserPermission::name(UserPermission::COMPANY, 'show'))
                            <li class="my-2">
                                <a
                                    class="w-full"
                                    href="/companies?limit=10"
                                >
                                    List
                                </a>
                            </li>
                            @can(UserPermission::name(UserPermission::COMPANY, 'store'))
                                <li class="my-2">
                                    <a
                                        class="w-full"
                                        href="/companies/create"
                                    >
                                        Create
                                    </a>
                                </li>
                            @endcan
                            @can(UserPermission::name(UserPermission::COMPANY, 'restore'))
                                <li class="my-2">
                                    <a
                                        class="w-full"
                                        href="/companies/restore?limit=10"
                                    >
                                        Removed
                                    </a>
                                </li>
                            @endcan
                        @endcan
                    </ul>
                </div>

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
                        class="flex items-center gap-2"
                        id="nav-dropdown-profile-btn"
                        data-dropdown-toggle="nav-dropdown-profile-menu"
                        data-dropdown-trigger="click"
                    >
                        <img
                            class="ring-default h-15 w-15 rounded-full object-cover p-1 ring-2"
                            src="{{ !Str::isUrl($user->image_path) ? asset('storage/' . $user->image_path) : $user->image_path }}"
                            alt="User avatar"
                        >
                        <x-fwb-o-adjustments-horizontal class="h-8 w-8 text-gray-500" />
                    </button>

                    <!-- Dropdown menu -->
                    <div
                        class="bg-neutral-primary-medium border-default-medium rounded-base z-10 hidden w-auto border px-2.5 py-2 shadow-lg"
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
                            @role('super')
                                <li>
                                    <p class="font-bold">Administrative</p>
                                </li>
                                <li>
                                    <a
                                        class="hover:bg-neutral-tertiary-medium hover:text-heading inline-flex w-full items-center rounded p-2"
                                        href="/administration/user/all?limit=10"
                                    >Users</a>
                                </li>
                                <li>
                                    <a
                                        class="hover:bg-neutral-tertiary-medium hover:text-heading inline-flex w-full items-center rounded p-2"
                                        href="/administration/company/all?limit=10"
                                    >Companies</a>
                                </li>
                                <li>
                                    <a
                                        class="hover:bg-neutral-tertiary-medium hover:text-heading inline-flex w-full items-center rounded p-2"
                                        href="/administration/supplier/all?limit=10"
                                    >Suppliers</a>
                                </li>
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
                            @endrole
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
                @endauth

                @guest
                    <div
                        class="border-b-0! hover:border-b-4! hover:border-t-4! border-primary-500 px-2 transition-all delay-150 duration-100 ease-in-out">
                        <a href="/login">Login</a>
                    </div>
                    <div
                        class="border-b-0! hover:border-b-4! hover:border-t-4! border-primary-500 px-2 transition-all delay-150 duration-100 ease-in-out">
                        <a href="/register">Register</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
