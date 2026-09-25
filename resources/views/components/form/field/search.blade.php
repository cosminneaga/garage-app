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

<div class="my-2 text-start">
    @if ($label)
        <label
            class="form-label"
            for="{{ $name }}"
        >{{ $label }}</label>
    @endif
    <div class="relative">
        <div
            class="inset-s-0 pointer-events-none absolute inset-y-0 flex items-center ps-3">
            <x-icon-o-magnifying-glass class="h-4 w-4 text-gray-500" />
        </div>
        <input
            class="form-item"
            {{ $attributes->merge([
                'value' => old($helper->get('errorName'), $value),
                'name' => $name,
                'id' => $name,
                'data-test' => $helper->get('testName'),
                'placeholder' => 'Search',
            ]) }}>
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
