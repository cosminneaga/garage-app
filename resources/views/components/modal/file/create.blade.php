@props(['id', 'action' => '#', 'trigger' => false, 'parent_name' => false, 'max_files' => 1])

@php
    $ids = BladeModalHelper::ids($id);
@endphp

<x-button
    id="{{ $ids->get('trigger') }}"
    data-modal-target="{{ $ids->get('modal') }}"
    data-modal-toggle="{{ $ids->get('modal') }}"
    type="button"
>Store File</x-button>

<x-modal.wrapper
    id="{{ $ids->get('modal') }}"
    title="Store file"
    size="7xl"
>
    <form
        id="{{ $ids->get('form') }}"
        action="{{ $action }}"
        method="POST"
        enctype="@enctype"
    >
        @csrf

        <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
            <section>
                <x-form.field.select
                    identifier="store_files"
                    name="{{ Str::generateFormFieldName('type', $parent_name) }}"
                    label="Type"
                    :options="FileType::selectOptions()"
                    map_value="value"
                    map_label="label"
                />
                <x-form.field.textarea
                    identifier="store_files"
                    name="{{ Str::generateFormFieldName('description', $parent_name) }}"
                    value="File description"
                    label="Description"
                />
            </section>
            <section>
                <h3 class="font-bold">Media</h3>
                <x-form.field.image
                    identifier="store_files"
                    name="{{ Str::generateFormFieldName('images[]', $parent_name) }}"
                    max_files="{{ $max_files }}"
                />
            </section>
        </div>

        <div class="grid grid-cols-1">
            <span class="text-danger text-sm font-bold">Max files accepted: {{ $max_files }}</span>

            <x-button
                id="{{ $ids->get('submit') }}"
                type="submit"
            >Submit</x-button>
        </div>

    </form>
</x-modal.wrapper>
