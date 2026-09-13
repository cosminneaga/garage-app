@props([
    'route' => route('home'),
    'label' => 'Search home...',
])

@if ($route)
    <x-slot name="header">
        <form
            class="flex items-center gap-2"
            method="GET"
            action="{{ $route }}"
        >
            <x-form.field.search
                identifier="table_search_box"
                name="search"
                value="{{ request('search') }}"
                label="{{ $label }}"
            />
        </form>
    </x-slot>
@endif
