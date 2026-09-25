@props([
    'name',
    'identifier' => 'select',
    'label' => false,
    'value' => null,
    'options' => [],
    'select_map_value' => 'value',
    'select_map_label' => [],
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
                value="{{ $option->$select_map_value }}"
                @selected($value == $option->$select_map_value)
            >
                @if (is_string($select_map_label))
                    {{ $option->$select_map_label }}
                @elseif (is_array($select_map_label))
                    @foreach ($select_map_label as $label)
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
