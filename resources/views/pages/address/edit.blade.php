@php
    $parameter = collect(Request::route()->parameters())
        ->keys()
        ->last();
    $tableName = RelatedModel::from($parameter)->tableName();
@endphp

<x-layout::index title="Address editing">
    <x-card>
        <form
            action="{{ route('addresses.' . $tableName . '.update', [Request::route('address'), Request::route($parameter)]) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-rows-1 gap-4 md:grid-cols-3">
                <x-form.content.address
                    identifier="address"
                    :countries="$countries"
                />
            </div>

            <div class="mt-5 flex gap-1">
                <x-button
                    id="address_update"
                    type="submit"
                >Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
