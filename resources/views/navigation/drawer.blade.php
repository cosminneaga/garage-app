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

    @permitted(UserPermission::USER, 'show')
    <br />
    <div class="border-default border-b">
        <span class="text-heading">Users</span>
    </div>
    <ul class="space-y-2 font-medium">
        <li class="my-2">
            <a
                class="w-full"
                href="{{ route('users.index') }}"
            > List </a>
        </li>
        @permitted(UserPermission::USER, 'store')
        <li class="my-2">
            <a
                class="w-full"
                href="{{ route('users.create') }}"
            > Create </a>
        </li>
        @endpermitted
        @permitted(UserPermission::USER, 'restore')
        <li class="my-2">
            <a
                class="w-full"
                href="{{ route('users.removed') }}"
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
                href="{{ route('managers.index') }}"
            > List </a>
        </li>
        @permitted(UserPermission::MANAGER, 'store')
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ route('managers.create') }}"
                > Create </a>
            </li>
        @endpermitted
        @permitted(UserPermission::MANAGER, 'restore')
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ route('managers.removed') }}"
                > Removed </a>
            </li>
        @endpermitted
    </ul>
    @endadministrator

    @permitted(UserPermission::COMPANY, 'show')
        <br />
        <div class="border-default border-b">
            <span class="text-heading">Companies</span>
        </div>
        <ul class="space-y-2 font-medium">
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ route('companies.index') }}"
                > List </a>
            </li>
            @permitted(UserPermission::COMPANY, 'store')
                <li class="my-2">
                    <a
                        class="w-full"
                        href="{{ route('companies.create') }}"
                    > Create </a>
                </li>
            @endpermitted
            @permitted(UserPermission::COMPANY, 'restore')
                <li class="my-2">
                    <a
                        class="w-full"
                        href="{{ route('companies.removed') }}"
                    > Removed </a>
                </li>
            @endpermitted
        </ul>
    @endpermitted

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
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ route('super.users.removed') }}"
                > Removed </a>
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
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ route('super.companies.removed') }}"
                > Removed </a>
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
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ route('super.suppliers.removed') }}"
                > Removed </a>
            </li>
        </ul>
    @endsuper
</div>
