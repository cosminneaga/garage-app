@props([
    'label' => false,
    'name',
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

    <textarea
        class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border p-3.5 text-sm"
        {{ $attributes->merge([
            'name' => $name,
            'id' => $name,
            'data-test' => $helper->get('testName'),
            'rows' => 10,
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @error($helper->get('errorName'))
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
