@props([
    'label' => false,
    'name',
    'id',
    'value' => null,
    'identifier' => '',
])

@php
    $helper = BladeFormHelper::names($identifier, $name);
@endphp

<div class="space-y-2 text-start">
    <div class="border-default bg-neutral-primary-soft rounded-base my-2 flex items-center border ps-4">
        <input
            class="text-neutral-primary border-default-medium bg-neutral-secondary-medium checked:border-brand focus:ring-brand-subtle h-4 w-4 appearance-none rounded-full border focus:outline-none focus:ring-2"
            {{ $attributes->merge([
                'value' => old($helper->get('errorName'), $value),
                'type' => 'radio',
                'name' => $name,
                'id' => $id,
                'data-test' => $helper->get('testName'),
            ]) }}
            x-bind:id="{{ $id }}"
        >
        <label
            class="text-heading ms-2 w-full select-none py-4 text-sm font-medium"
            for={{ $id }}
            x-text="{{ $label }}"
            x-bind:for="{{ $id }}"
        >{{ $label }}</label>
    </div>

    @error($helper->get('errorName'))
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
