<div
    class="bg-neutral-primary-soft border-default text-heading fixed left-0 top-0 z-40 h-screen w-96 -translate-x-full overflow-y-auto border-e p-4 transition-transform"
    id="app-drawer"
    aria-labelledby="drawer-label"
    tabindex="-1"
>
    <div class="flex items-end gap-2 pb-4">
        <img
            class="h-auto w-20 rounded-sm"
            src="{{ asset('logo-4x3.webp') }}"
            title="GarageApp Logo"
            alt="GarageApp Logo"
        />
        <span
            class="text-heading self-center whitespace-nowrap text-lg font-semibold"
        >Garage App</span>
    </div>

    @super
        <br />
        <div class="border-default border-b">
            <span class="text-heading">Users</span>
        </div>
        <ul class="space-y-2 font-medium">
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ route('super.users.all') }}"
                > List </a>
            </li>
        </ul>

        <br />
        <div class="border-default border-b">
            <span class="text-heading">Companies</span>
        </div>
        <ul class="space-y-2 font-medium">
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ route('super.companies.all') }}"
                > List </a>
            </li>
        </ul>

        <br />
        <div class="border-default border-b">
            <span class="text-heading">Suppliers</span>
        </div>
        <ul class="space-y-2 font-medium">
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ route('super.suppliers.all') }}"
                > List </a>
            </li>
        </ul>
    @endsuper

    @permitted(UserPermission::USER, 'show')
    <br />
    <div class="border-default border-b">
        <span class="text-heading">Users</span>
    </div>
    <ul class="space-y-2 font-medium">
        <li class="my-2">
            <a
                class="w-full"
                href="/users"
            > List </a>
        </li>
        @permitted(UserPermission::USER, 'store')
        <li class="my-2">
            <a
                class="w-full"
                href="/users/create"
            > Create </a>
        </li>
        @endpermitted
        @permitted(UserPermission::USER, 'restore')
        <li class="my-2">
            <a
                class="w-full"
                href="/users/restore"
            > Removed </a>
        </li>
        @endpermitted
    </ul>
    @endpermitted

    @permitted(UserPermission::MANAGER, 'show')
    <br />
    <div class="border-default border-b">
        <span class="text-heading">Managers</span>
    </div>
    <ul class="space-y-2 font-medium">
        <li class="my-2">
            <a
                class="w-full"
                href="/managers"
            > List </a>
        </li>
        @permitted(UserPermission::MANAGER, 'store')
            <li class="my-2">
                <a
                    class="w-full"
                    href="/managers/create"
                > Create </a>
            </li>
        @endpermitted
        @permitted(UserPermission::MANAGER, 'restore')
            <li class="my-2">
                <a
                    class="w-full"
                    href="/managers/restore"
                > Removed </a>
            </li>
        @endpermitted
    </ul>
    @endadministrator

    <br />
    <div class="border-default border-b">
        <span class="text-heading">Companies</span>
    </div>
    <ul class="space-y-2 font-medium">
        @permitted(UserPermission::COMPANY, 'show')
            <li class="my-2">
                <a
                    class="w-full"
                    href="/companies"
                > List </a>
            </li>
            @permitted(UserPermission::COMPANY, 'store')
                <li class="my-2">
                    <a
                        class="w-full"
                        href="/companies/create"
                    > Create </a>
                </li>
            @endpermitted
            @permitted(UserPermission::COMPANY, 'restore')
                <li class="my-2">
                    <a
                        class="w-full"
                        href="/companies/restore"
                    > Removed </a>
                </li>
            @endpermitted
        @endpermitted
    </ul>
</div>
