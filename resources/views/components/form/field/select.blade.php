@props([
    'label' => false,
    'name',
    'value' => null,
    'options' => [],
    'select_map_value' => 'value',
    'select_map_label' => 'label',
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
    <select
        class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
        {{ $attributes->merge([
            'value' => old($helper->get('errorName'), $value),
            'name' => $name,
            'id' => $name,
            'data-test' => $helper->get('testName'),
        ]) }}
    >
        @foreach ($options as $option)
            <option
                value="{{ $option[$select_map_value] }}"
                @selected($value === $option[$select_map_value])
            >
                {{ $option[$select_map_label] }}
            </option>
        @endforeach
    </select>

    @error($helper->get('errorName'))
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
