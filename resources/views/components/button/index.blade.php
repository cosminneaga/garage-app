@props([
    'id' => 'btn',
    'form' => null
])

<button
    class="bg-brand hover:bg-brand-strong focus:ring-brand-medium shadow-xs rounded-base box-border border border-transparent px-4 py-2.5 text-sm font-medium leading-5 text-white focus:outline-none focus:ring-4""
    data-test="{{ $id }}"
    id="{{ $id }}"
    form="{{ $form }}"
>{{ $slot }}</button>
