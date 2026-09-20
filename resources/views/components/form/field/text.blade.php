@props(['name', 'identifier' => '', 'label' => false, 'value' => null])

@php
    $helper = BladeFormHelper::names($identifier, $name);
@endphp

<div class="my-3 text-start">
    @if ($label)
        <label
            class="form-label"
            for="{{ $name }}"
        >{{ $label }}</label>
    @endif

    <input
        class="form-item"
        {{ $attributes->merge([
            'value' => old($helper->get('errorName'), $value),
            'name' => $name,
            'id' => $name,
            'data-test' => $helper->get('testName'),
        ]) }}
    />

    @error($helper->get('errorName'))
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
