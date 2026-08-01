@php
    Session::flashInput($resource->toArray());
@endphp

<x-layout::index title="{{ $resource->name }} | Details">
    <x-tabs :tabs="SupplierTabs::ui()">
        <x-card
            :title="$resource->name"
            description="Visualise & Edit {{ $resource->name }}'s details"
        >
            <form
                @isset($company)
                    :action="route('suppliers.companies.update', [
                        $company,
                        $resource,
                    ])"
                @else
                    :action="route('super.suppliers.update', $resource)"
                @endisset
                method="POST"
            >
                @csrf
                @method ('PUT')

                <x-form.content.supplier identifier="supplier" />

                <div class="mt-5 flex gap-1">
                    <x-button
                        id="supplier_update_submit"
                        class="w-fit"
                        type="submit"
                    >UPDATE</x-button>

                    <x-button
                        id="supplier-delete-modal-trigger"
                        data-modal-target="supplier-delete-modal"
                        data-modal-toggle="supplier-delete-modal"
                        type="button"
                        variant="danger"
                    >DELETE</x-button>
                </div>
            </form>

            <x-modal.confirm
                id="supplier-delete"
                type="delete"
                action="{{ route('super.suppliers.destroy', $resource->id) }}"
                message="Are you sure you want to remove {{ $resource->name }}?"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
