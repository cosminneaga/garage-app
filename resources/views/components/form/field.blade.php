@props([
    'label' => false,
    'name',
    'type' => 'text',
    'placeholder' => '',
    'autocomplete' => false,
    'value' => null,
    'options' => [],
    'select_map_value' => 'name',
    'select_map_label' => 'label',
    'checked' => false,
])

@php
    $testName = Str::replace(['[', ']'], ['_', ''], $name);
    $errorName = Str::replace(['[', ']'], ['.', ''], $name);
@endphp

<div class="space-y-2 text-start">

    @if ($label)
        <label
            class="text-heading mb-1.25 text-md block font-medium"
            for="{{ $name }}"
        >{{ $label }}</label>
    @endif

    <div class="mb-5">
        @switch($type)
            @case('textarea')
                <textarea
                    class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border p-3.5 text-sm"
                    {{ $attributes->merge([
                        'name' => $name,
                        'id' => $name,
                        'data-test' => $testName,
                    ]) }}
                >{{ old($name, $value) }}</textarea>
            @break

            @case('image')
                <x-form.file.image
                    :name="$name"
                    :test="$testName"
                />
            @break

            @case('select')
                <select
                    class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                    {{ $attributes->merge([
                        'value' => old($errorName, $value),
                        'type' => $type,
                        'name' => $name,
                        'id' => $name,
                        'data-test' => $testName,
                    ]) }}
                >
                    @foreach ($options as $option)
                        <option value="{{ $option[$select_map_value] }}">{{ $option[$select_map_label] }}</option>
                    @endforeach
                </select>
            @break

            @case('toggle')
                <label class="inline-flex cursor-pointer items-center">
                    @isset($before)
                        {{ $before }}
                    @endisset
                    <input
                        class="peer sr-only"
                        {{ $attributes->merge([
                            'type' => 'checkbox',
                            'name' => $name,
                            'id' => $name,
                            'data-test' => $testName,
                            'checked' => filter_var($checked, FILTER_VALIDATE_BOOLEAN),
                            'value' => old($errorName, $value),
                        ]) }}
                    >
                    <div
                        class="bg-neutral-quaternary peer-focus:ring-brand-soft dark:peer-focus:ring-brand-soft peer-checked:after:border-buffer peer-checked:bg-brand after:inset-s-0.5 peer relative mx-3 h-5 w-9 rounded-full after:absolute after:top-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-focus:outline-none peer-focus:ring-4 rtl:peer-checked:after:-translate-x-full">
                    </div>
                    @isset($after)
                        {{ $after }}
                    @endisset
                </label>
            @break

            @default
                <input
                    class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                    {{ $attributes->merge([
                        'value' => old($errorName, $value),
                        'type' => $type,
                        'name' => $name,
                        'id' => $name,
                        'data-test' => $testName,
                    ]) }}
                />
            @break

        @endswitch
        @error($errorName)
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
