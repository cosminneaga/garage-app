@props([
    'label',
    'show' => [UserPermission::COMPANY, 'show'],
    'store' => [UserPermission::COMPANY, 'store'],
    'restore' => [UserPermission::COMPANY, 'restore'],
    'route_list' => false,
    'route_store' => false,
    'route_restore' => false,
])

@permitted($show[0], $show[1])
    <br />
    <div class="border-default border-b">
        <span class="text-heading">{{ $label }}</span>
    </div>

    <ul class="space-y-2 font-medium">
        <li class="my-2">
            <a
                class="w-full"
                href="{{ $route_list }}"
            > List </a>
        </li>
        @permitted($store[0], $store[1])
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ $route_store }}"
                > Create </a>
            </li>
        @endpermitted
        @permitted($restore[0], $restore[1])
            <li class="my-2">
                <a
                    class="w-full"
                    href="{{ $route_restore }}"
                > Removed </a>
            </li>
        @endpermitted
    </ul>
@endpermitted
