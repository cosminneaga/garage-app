@php
    $parameter = collect(Request::route()->parameters())
        ->keys()
        ->last();
    $tableName = RelatedModel::from($parameter)->tableName();
@endphp

<x-layout::index title="Contact editing">
    <x-card>
        <form
            action="{{ route('contacts.' . $tableName . '.update', [Request::route('contact'), Request::route($parameter)]) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-rows-1 gap-4">
                <x-form.content.contact identifier="contact" />
            </div>

            <div class="mt-5 flex gap-1">
                <x-button
                    id="contact_update"
                    type="submit"
                >Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
