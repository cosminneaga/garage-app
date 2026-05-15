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
    'checked' => true,
])

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
                    id="{{ $name }}"
                    name="{{ $name }}"
                    data-test="{{ $name }}"
                    {{ $attributes }}
                >{{ old($name, $value) }}</textarea>
            @break

            @case('select')
                <select
                    class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                    id="{{ $name }}"
                    name="{{ $name }}"
                    data-test="{{ $name }}"
                    {{ $attributes }}
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
                        id="{{ $name }}"
                        name="{{ $name }}"
                        data-test="{{ $name }}"
                        type="checkbox"
                        value="{{ $checked }}"
                        {{ $checked == 'true' ? 'checked' : '' }}
                    >
                    <div
                        class="bg-neutral-quaternary peer-focus:ring-brand-soft dark:peer-focus:ring-brand-soft peer-checked:after:border-buffer peer-checked:bg-brand peer relative mx-3 h-5 w-9 rounded-full after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-focus:outline-none peer-focus:ring-4 rtl:peer-checked:after:-translate-x-full">
                    </div>
                    @isset($after)
                        {{ $after }}
                    @endisset
                </label>
            @break

            @default
                <input
                    class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                    id="{{ $name }}"
                    name="{{ $name }}"
                    data-test="{{ $name }}"
                    type="{{ $type }}"
                    value="{{ old($name, $value) }}"
                    {{ $attributes }}
                />
            @break

        @endswitch
        @error($name)
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
