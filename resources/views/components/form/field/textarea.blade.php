@props([
    'label' => false,
    'name',
    'value' => null,
    'identifier' => '',
])

@php
    $testName = $identifier . '_' . Str::replace(['[', ']'], ['_', ''], $name);
    $errorName = Str::replace(['[', ']'], ['.', ''], $name);
@endphp

<div class="space-y-2 text-start">
    @if ($label)
        <label
            class="text-heading mb-1.25 text-md block font-medium"
            for="{{ $name }}"
        >{{ $label }}</label>
    @endif

    <textarea
        class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border p-3.5 text-sm"
        {{ $attributes->merge([
            'name' => $name,
            'id' => $name,
            'data-test' => $testName,
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @error($errorName)
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
