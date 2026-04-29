<?php
$user = Auth::user();
?>

<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-24 flex items-center justify-between">
        <div>
            <div class="flex gap-2 items-center">

                <a href="/">
                    <img
                        class="w-20 h-auto rounded-sm"
                        src="{{ asset('logo-4x3.webp') }}"
                        title="GarageApp Logo"
                        alt="GarageApp Logo"
                    />
                </a>

                @auth
                    @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::USER, 'show'))
                        <x-bladewind.dropmenu position="left">
                            <x-slot:trigger>

                                <x-bladewind.button
                                    type="secondary"
                                    size="small"
                                    outline
                                >Users</x-bladewind.button>
                            </x-slot:trigger>


                            <a
                                class="w-full"
                                href="/users?limit=10"
                            >
                                <x-bladewind.dropmenu.item
                                    icon="users">Team</x-bladewind.dropmenu.item>
                            </a>

                            @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::USER, 'store'))
                                <a
                                    class="w-full"
                                    href="/users/create"
                                >
                                    <x-bladewind.dropmenu.item
                                        icon="folder-plus">Create</x-bladewind.dropmenu.item>
                                </a>
                            @endcan
                            @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::USER, 'restore'))
                                <x-bladewind.dropmenu.item header>
                                    <p class="font-bold">Administrative</p>
                                </x-bladewind.dropmenu.item>
                                <a
                                    class="w-full"
                                    href="/users/restore?limit=10"
                                >
                                    <x-bladewind.dropmenu.item
                                        icon="archive-box-x-mark">Removed</x-bladewind.dropmenu.item>
                                </a>
                            @endcan
                        </x-bladewind.dropmenu>
                    @endcan

                    <x-bladewind.dropmenu position="left">
                        <x-slot:trigger>
                            <x-bladewind.button
                                type="secondary"
                                size="small"
                                outline
                            >Companies</x-bladewind.button>
                        </x-slot:trigger>


                        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::COMPANY, 'show'))
                            <a
                                class="w-full"
                                href="/companies?limit=10"
                            >
                                <x-bladewind.dropmenu.item
                                    icon="table-cells">List</x-bladewind.dropmenu.item>
                            </a>
                        @endcan
                        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::COMPANY, 'store'))
                            <a
                                class="w-full"
                                href="/companies/create"
                            >
                                <x-bladewind.dropmenu.item
                                    icon="folder-plus">Create</x-bladewind.dropmenu.item>
                            </a>
                        @endcan
                        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::COMPANY, 'restore'))
                            <x-bladewind.dropmenu.item header>
                                <p class="font-bold">Administrative</p>
                            </x-bladewind.dropmenu.item>
                            <a
                                class="w-full"
                                href="/companies/restore?limit=10"
                            >
                                <x-bladewind.dropmenu.item
                                    icon="archive-box-x-mark">Removed</x-bladewind.dropmenu.item>
                            </a>
                        @endcan
                    </x-bladewind.dropmenu>

                    <x-bladewind.dropmenu position="left">
                        <x-slot:trigger>
                            <x-bladewind.button
                                type="secondary"
                                size="small"
                                outline
                            >Suppliers</x-bladewind.button>
                        </x-slot:trigger>

                        @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::SUPPLIER, 'show'))
                            <a
                                class="w-full"
                                href="/suppliers?limit=10"
                            >
                                <x-bladewind.dropmenu.item
                                    icon="table-cells">List</x-bladewind.dropmenu.item>
                            </a>
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
                                        class="rounded-sm!"
                                        size="regular"
                                        show_ring="false"
                                        :image="!Str::isUrl(
                                            $user->image_path,
                                        )
                                            ? asset(
                                                'storage/' . $user->image_path,
                                            )
                                            : $user->image_path"
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
                                    href="/administration/user/all?limit=10"
                                >Users</a>
                            </x-bladewind.dropmenu.item>
                            <x-bladewind.dropmenu.item icon="building-office">
                                <a
                                    class="w-full"
                                    href="/administration/company/all?limit=10"
                                >Companies</a>
                            </x-bladewind.dropmenu.item>
                            <x-bladewind.dropmenu.item icon="building-office">
                                <a
                                    class="w-full"
                                    href="/administration/supplier/all?limit=10"
                                >Suppliers</a>
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
                    <div
                        class="px-2 border-b-0! border-primary-500 transition-all ease-in-out delay-150 duration-100 hover:border-b-4! hover:border-t-4!">
                        <a href="/register">Register</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
