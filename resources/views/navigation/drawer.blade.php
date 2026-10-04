<div
    id="app-drawer"
    aria-labelledby="drawer-label"
    tabindex="-1"
    {{ $attributes->merge([
        'class' =>
            'bg-neutral-primary-soft border-default text-heading overflow-y-auto border-e p-4 max-w-96 min-w-60 min-h-screen left-0 top-0 z-40 transition-transform',
    ]) }}
>
    <div class="flex flex-col items-start gap-2 pb-4">
        {{-- <img
            class="h-auto w-20 rounded-sm"
            src="{{ asset('logo-4x3.webp') }}"
            title="GarageApp Logo"
            alt="GarageApp Logo"
        /> --}}
        <span class="text-heading whitespace-nowrap text-xl font-semibold">
            Garage App
        </span>
    </div>

    <x-navigation.group
        title="Users"
        :permission="[UserPermission::USER, 'show']"
        :items="[
            [
                'type' => 'single',
                'title' => 'List of Users',
                'icon' => 'icon-o-table-cells',
                'permission' => [UserPermission::USER, 'show'],
                'route' => route('users.index'),
            ],
            [
                'type' => 'single',
                'title' => 'Create',
                'icon' => 'icon-o-document-plus',
                'permission' => [UserPermission::USER, 'store'],
                'route' => route('users.create'),
            ],
            [
                'type' => 'single',
                'title' => 'Removed Users',
                'icon' => 'icon-o-document-minus',
                'permission' => [UserPermission::USER, 'restore'],
                'route' => route('users.removed'),
            ],
            [
                'type' => 'dropdown',
                'title' => 'Managers',
                'icon' => 'icon-o-user-group',
                'permission' => [UserPermission::MANAGER, 'show'],
                'items' => [
                    [
                        'title' => 'Create',
                        'icon' => 'icon-o-document-plus',
                        'route' => route('managers.create'),
                        'permission' => [UserPermission::MANAGER, 'store'],
                    ],
                    [
                        'title' => 'List',
                        'icon' => 'icon-o-table-cells',
                        'route' => route('managers.index'),
                        'permission' => [UserPermission::MANAGER, 'show'],
                    ],
                    [
                        'title' => 'Removed',
                        'icon' => 'icon-o-document-minus',
                        'permission' => [UserPermission::MANAGER, 'restore'],
                        'route' => route('managers.removed'),
                    ],
                ],
            ],
        ]"
    />

    <x-navigation.group
        title="Work"
        :permission="[UserPermission::WORKORDER, 'show']"
        :items="[
            [
                'type' => 'dropdown',
                'title' => 'Workorders',
                'icon' => 'icon-o-briefcase',
                'permission' => [UserPermission::WORKORDER, 'show'],
                'items' => [
                    [
                        'title' => 'Assigned',
                        'icon' => 'icon-o-table-cells',
                        'route' => route('workorders.index'),
                        'permission' => [UserPermission::WORKORDER, 'show'],
                    ],
                    [
                        'title' => 'By default Company',
                        'icon' => 'icon-o-building-office',
                        'route' => Auth::user()->setting ? route('workorders.companies.index', Auth::user()->setting->default_company) : '#',
                        'permission' => [UserPermission::WORKORDER, 'show'],
                    ],
                ],
            ],
        ]"
    />

    <x-navigation.group
        title="Company"
        :permission="[UserPermission::COMPANY, 'show']"
        :items="[
            [
                'type' => 'single',
                'title' => 'List of Companies',
                'icon' => 'icon-o-building-office',
                'route' => route('companies.index'),
                'permission' => [UserPermission::COMPANY, 'show'],
            ],
            [
                'type' => 'single',
                'title' => 'Create',
                'icon' => 'icon-o-document-plus',
                'route' => route('companies.create'),
                'permission' => [UserPermission::COMPANY, 'store'],
            ],
            [
                'type' => 'single',
                'title' => 'Removed',
                'icon' => 'icon-o-document-minus',
                'route' => route('companies.removed'),
                'permission' => [UserPermission::COMPANY, 'restore'],
            ],
            [
                'type' => 'dropdown',
                'title' => 'Bookings',
                'icon' => 'icon-o-calendar-days',
                'permission' => [UserPermission::BOOKING, 'show'],
                'items' => [
                    [
                        'title' => 'List of Bookings',
                        'icon' => 'icon-o-table-cells',
                        'route' => route('bookings.index'),
                        'permission' => [UserPermission::BOOKING, 'show'],
                    ],
                    [
                        'title' => 'Create for Default Company',
                        'icon' => 'icon-o-document-plus',
                        'route' => Auth::user()->setting ? route('bookings.companies.create', Auth::user()->setting->default_company) : '#',
                        'permission' => [UserPermission::BOOKING, 'store'],
                    ],
                ],
            ],
        ]"
    />

    @super
        <x-navigation.link-list.direct
            label="Users"
            route_list="{{ route('super.users.all') }}"
            route_removed="{{ route('super.users.removed') }}"
        />

        <x-navigation.link-list.direct
            label="Companies"
            route_list="{{ route('super.companies.all') }}"
            route_removed="{{ route('super.companies.removed') }}"
        />

        <x-navigation.link-list.direct
            label="Suppliers"
            route_list="{{ route('super.suppliers.all') }}"
            route_removed="{{ route('super.suppliers.removed') }}"
        />
    @endsuper
</div>
