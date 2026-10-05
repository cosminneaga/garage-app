@props([
    'name',
    'identifier' => 'select',
    'value' => null,
    'label' => false,
    'options' => [],
    'map_value' => 'value',
    'map_label' => 'label',
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
    <select
        class="form-item"
        {{ $attributes->merge([
            'value' => old($helper->get('errorName'), $value),
            'name' => $name,
            'id' => $name,
            'data-test' => $helper->get('testName'),
        ]) }}
    >
        @foreach ($options as $option)
            <option
                value="{{ $option->$map_value }}"
                @selected($value == $option->$map_value)
            >
                @if (is_string($map_label))
                    {{ $option->$map_label }}
                @elseif (is_array($map_label))
                    @foreach ($map_label as $label)
                        {{ $option[$label] }} |
                    @endforeach
                @endif
            </option>
        @endforeach
    </select>

    @error($helper->get('errorName'))
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
