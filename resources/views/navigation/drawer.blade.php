<div
    id="app-drawer"
    aria-labelledby="drawer-label"
    tabindex="-1"
    {{ $attributes->merge([
        'class' =>
            'bg-neutral-primary-soft border-default text-heading overflow-y-auto border-e p-4 max-w-96 min-h-screen left-0 top-0 z-40 transition-transform',
    ]) }}
>
    <div class="flex flex-col items-start gap-2 pb-4">
        {{-- <img
            class="h-auto w-20 rounded-sm"
            src="{{ asset('logo-4x3.webp') }}"
            title="GarageApp Logo"
            alt="GarageApp Logo"
        /> --}}
        <span class="text-heading whitespace-nowrap text-xl font-semibold">Garage
            App</span>
    </div>

    <x-navigation.link-list.permission
        label="Users"
        :show="[UserPermission::USER, 'show']"
        :store="[UserPermission::USER, 'store']"
        :restore="[UserPermission::USER, 'restore']"
        route_list="{{ route('users.index') }}"
        route_store="{{ route('users.create') }}"
        route_restore="{{ route('users.removed') }}"
    />

    <x-navigation.link-list.permission
        label="Managers"
        :show="[UserPermission::MANAGER, 'show']"
        :store="[UserPermission::MANAGER, 'store']"
        :restore="[UserPermission::MANAGER, 'restore']"
        route_list="{{ route('managers.index') }}"
        route_store="{{ route('managers.create') }}"
        route_restore="{{ route('managers.removed') }}"
    />

    <x-navigation.link-list.permission
        label="Companies"
        :show="[UserPermission::COMPANY, 'show']"
        :store="[UserPermission::COMPANY, 'store']"
        :restore="[UserPermission::COMPANY, 'restore']"
        route_list="{{ route('companies.index') }}"
        route_store="{{ route('companies.create') }}"
        route_restore="{{ route('companies.removed') }}"
    />

    <x-navigation.link-list.permission
        label="Bookings"
        :show="[UserPermission::BOOKING, 'show']"
        :store="[UserPermission::BOOKING, 'store']"
        :restore="[UserPermission::BOOKING, 'restore']"
        route_list="{{ route('bookings.index') }}"
        route_store="{{ route('bookings.create') }}"
        {{-- route_restore="{{ route('bookings.removed') }}" --}}
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
