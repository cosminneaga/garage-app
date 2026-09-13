@props(['label', 'route_list', 'route_removed' => false])

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
    @if ($route_removed)
        <li class="my-2">
            <a
                class="w-full"
                href="{{ $route_removed }}"
            > Removed </a>
        </li>
    @endif
</ul>
