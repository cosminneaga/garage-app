@php
    Session::flashInput($resource->toArray());
@endphp

<x-layout::index title="{{ $resource->name }}">
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card description="Visualise & Edit {{ $resource->name }} details">
            <form
                id="form-company-update"
                action="{{ route('super.companies.update', $resource) }}"
                method="POST"
                enctype="@enctype"
            >
                @csrf
                @method('PUT')

                <img
                    class="h-24 w-24 rounded-full border-4 border-white object-cover"
                    src="{{ $resource->image_path && !Str::isUrl($resource->image_path) ? asset('storage/' . $resource->image_path) : $resource->image_path }}"
                    alt="alt"
                />
                <br />

                <x-form.content.company identifier="company-update" />

                <div class="mt-5 flex gap-1">
                    <x-button
                        class="w-fit"
                        id="form-company-update-submit"
                        form="form-company-update"
                        type="submit"
                    >Update Details</x-button>

                    <x-button
                        id="company-delete-modal-trigger"
                        data-modal-target="company-delete-modal"
                        data-modal-toggle="company-delete-modal"
                        type="button"
                        variant="danger"
                    >Delete Company</x-button>
                </div>
            </form>
            <x-modal.confirm
                id="company-delete"
                type="delete"
                action="{{ route('companies.destroy', $resource->id) }}"
                message="Are you sure you want to remove {{ $resource->name }} from your list of companies?"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
