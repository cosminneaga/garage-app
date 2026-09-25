@props(['name', 'identifier' => '', 'label' => false])

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

    <input
        {{ $attributes->merge([
            'class' => 'form-item',
            'name' => $name,
            'id' => $name,
            'data-test' => $helper->get('testName'),
        ]) }}>

    @error($helper->get('errorName'))
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
