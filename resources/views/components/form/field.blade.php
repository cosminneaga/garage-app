@props([
    'label' => false,
    'name',
    'type' => 'text',
    'placeholder' => '',
    'autocomplete' => false,
    'value' => null,
    'options' => [],
    'select_map_value' => 'value',
    'select_map_label' => 'label',
    'checked' => false,
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

    <div class="relative">
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
                    :identifier="$testName"
                    :name="$name"
                    :id="$testName"
                    :data-test="$testName"
                    {{ $attributes }}
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
                        <option
                            value="{{ $option[$select_map_value] }}"
                            @selected(old($errorName, $value) === $option[$select_map_value])
                        >
                            {{ $option[$select_map_label] }}
                        </option>
                    @endforeach
                </select>
            @break

            @case('checkbox')
            @case('toggle')

            @case('switch')
                <div class="flex gap-2">
                    @isset($before)
                        {{ $before }}
                    @endisset
                    <div class="relative w-11 cursor-pointer">
                        <input
                            class="absolute-center @testing z-1 @endtesting peer"
                            type="checkbox"
                            {{ $attributes->merge([
                                'name' => $name,
                                'id' => $name,
                                'data-test' => $testName,
                                'checked' => filter_var($checked, FILTER_VALIDATE_BOOLEAN),
                            ]) }}
                        />

                        <label
                            class="absolute-center bg-neutral-quaternary peer-focus:ring-brand-soft dark:peer-focus:ring-brand-soft peer-checked:after:border-buffer peer-checked:bg-brand after:inset-s-0.5 peer h-5 w-9 rounded-full after:absolute after:top-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-focus:outline-none peer-focus:ring-4 rtl:peer-checked:after:-translate-x-full"
                            for={{ $name }}
                        >
                        </label>
                    </div>
                    @isset($after)
                        {{ $after }}
                    @endisset
                </div>
            @break

            @case('search')
                <label
                    class="text-heading sr-only mb-2.5 block text-sm font-medium"
                    for="search"
                >Search</label>
                <div class="relative">
                    <div
                        class="inset-s-0 pointer-events-none absolute inset-y-0 flex items-center ps-3">
                        <x-fwb-o-search class="h-4 w-4 text-gray-500" />
                    </div>
                    <input
                        class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border p-3 ps-9 text-sm"
                        {{ $attributes->merge([
                            'value' => old($errorName, $value),
                            'name' => $name,
                            'id' => $name,
                            'data-test' => $testName,
                            'placeholder' => 'Search',
                        ]) }}
                    />
                    <button
                        class="bg-brand hover:bg-brand-strong focus:ring-brand-medium shadow-xs inset-e-1.5 absolute bottom-1.5 box-border rounded border border-transparent px-3 py-1.5 text-xs font-medium leading-5 text-white focus:outline-none focus:ring-4"
                        {{ $attributes->merge([
                            'type' => 'submit',
                            'id' => $name . '-submit',
                            'data-test' => $name . '-submit',
                        ]) }}
                    >Search</button>
                </div>
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
