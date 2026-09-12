@props([
    'label' => false,
    'name',
    'placeholder' => '',
    'autocomplete' => false,
    'value' => null,
    'identifier' => '',
])

@php
    $helper = BladeFormHelper::names($identifier, $name);
@endphp

<div class="space-y-2 text-start">
    @if ($label)
        <label
            class="text-heading mb-1.25 text-md block font-medium"
            for="{{ $name }}"
        >{{ $label }}</label>
    @endif

    <label
        class="text-heading sr-only mb-2.5 block text-sm font-medium"
        for="search"
    >Search</label>
    <div class="relative">
        <div
            class="inset-s-0 pointer-events-none absolute inset-y-0 flex items-center ps-3">
            <x-fwb-o-search class="h-4 w-4 text-gray-500" />
        </div>
        <input
            class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border p-3 ps-9 text-sm"
            {{ $attributes->merge([
                'value' => old($helper->get('errorName'), $value),
                'name' => $name,
                'id' => $name,
                'data-test' => $helper->get('testName'),
                'placeholder' => 'Search',
            ]) }}
        />
        <button
            class="bg-brand hover:bg-brand-strong focus:ring-brand-medium shadow-xs inset-e-1.5 absolute bottom-1.5 box-border rounded border border-transparent px-3 py-1.5 text-xs font-medium leading-5 text-white focus:outline-none focus:ring-4"
            {{ $attributes->merge([
                'type' => 'submit',
                'id' => $helper->get('testName') . '_submit',
                'data-test' => $helper->get('testName') . '_submit',
            ]) }}
        >Search</button>
    </div>

    @error($helper->get('errorName'))
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
