@props([
    'label' => false,
    'legend' => false,
    'name',
    'type' => 'text',
    'varname' => '',
    'inputtype' => '',
    'placeholder' => '',
    'autocomplete' => false,
    'value' => null,
])

<div class="space-y-2 text-start">

    @if ($label)
        <label
            class="label"
            for="{{ $name }}"
        >{{ $label }}</label>
    @endif

    @switch($type)
        @case('textarea')
            <textarea
                class="input"
                id="{{ $name }}"
                name="{{ $name }}"
                {{ $attributes }}
            >{{ old($name, $value) }}</textarea>
        @break

        @default
            <input
                class="input"
                id="{{ $name }}"
                name="{{ $name }}"
                type="{{ $type }}"
                value="{{ old($name, $value) }}"
                {{ $attributes }}
            />
        @break
    @endswitch

    @error($name)
        <p class="text-red-600 text-xs">{{ $message }}</p>
    @enderror
</div>
