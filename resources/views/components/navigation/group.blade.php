@props([
    'title',
    'permission' => [UserPermission::USER, 'show'],
    'items' => [
        [
            'type' => 'single',
            'title' => 'List of all users',
            'icon' => 'icon-o-user',
            'route' => route('users.index'),
            'permission' => [UserPermission::USER, 'show'],
        ],
        [
            'type' => 'dropdown',
            'title' => 'User',
            'icon' => 'icon-o-user',
            'permission' => [UserPermission::USER, 'show'],
            'items' => [
                [
                    'title' => 'List',
                    'icon' => 'icon-o-user',
                    'route' => route('users.index'),
                    'permission' => [UserPermission::USER, 'show'],
                ],
            ],
        ],
    ],
])


@permitted(...$permission)
    <div class="mb-3">
        <div class="border-gray-600 border-b pb-1.5">
            <span class="text-base font-bold ml-3">{{ $title }}</span>
        </div>

        <ul class="font-medium mt-2">
            @foreach ($items as $item)
                @permitted(...$item['permission'])
                    @if ($item['type'] === 'single')
                        <li class="link-item-single">
                            @if (array_key_exists('icon', $item))
                                @svg($item['icon'], 'w-6 h-6')
                            @endif
                            <a
                                class="link-button"
                                href="{{ $item['route'] }}"
                            >{{ $item['title'] }}</a>
                        </li>
                    @elseif ($item['type'] === 'dropdown')
                        <li>
                            <div class="link-item-single">

                                <button
                                    class="link-button pl-0 ml-0"
                                    data-collapse-toggle="{{ $item['title'] }}-dropdown"
                                    aria-controls="{{ $item['title'] }}-dropdown"
                                >
                                    @if (array_key_exists('icon', $item))
                                        @svg($item['icon'], 'w-6 h-6')
                                    @endif
                                    <span class="flex-1 whitespace-nowrap text-left rtl:text-right">{{ $item['title'] }}</span>
                                    <x-icon-o-chevron-down />
                                </button>
                            </div>
                            <ul
                                class="hidden pl-1.5 font-medium"
                                id="{{ $item['title'] }}-dropdown"
                            >
                                @foreach ($item['items'] as $subitem)
                                    @permitted(...$subitem['permission'])
                                        <li class="link-item-single pl-1.5">
                                            @if (array_key_exists('icon', $subitem))
                                                @svg($subitem['icon'], 'w-6 h-6')
                                            @endif
                                            <a
                                                class="link-button"
                                                href="{{ $subitem['route'] }}"
                                            >{{ $subitem['title'] }}</a>
                                        </li>
                                        {{-- <div class="w-5/6 border-b border-gray-600"></div> --}}
                                    @endpermitted
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endpermitted
            @endforeach
        </ul>
    </div>
@endpermitted
