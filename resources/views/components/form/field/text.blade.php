@props(['name', 'identifier' => '', 'label' => false, 'visible' => true])

@php
    $helper = BladeFormHelper::names($identifier, $name);
@endphp

<div @class(['text-start', 'my-2' => $visible])>
    @if ($label)
        <label
            class="form-label"
            for="{{ $name }}"
        >{{ $label }}</label>
    @endif

    <input
        @class(['form-item', 'hidden' => !$visible])
        {{ $attributes->merge([
            'name' => $name,
            'id' => $name,
            'data-test' => $helper->get('testName'),
        ]) }}
    >

    @error($helper->get('errorName'))
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
