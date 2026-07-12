@php
    Session::flashInput($company->toArray());
@endphp

<x-layout::index title="{{ $company->name }}">
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card description="Visualise & Edit {{ $company->name }} details">
            <form
                id="form-company-update"
                action="{{ route('companies.update', $company) }}"
                method="POST"
                enctype="@enctype"
            >
                @csrf
                @method('PUT')

                <img
                    class="h-24 w-24 rounded-full border-4 border-white object-cover"
                    src="{{ $company->image_path && !Str::isUrl($company->image_path) ? asset('storage/' . $company->image_path) : $company->image_path }}"
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

                    @permitted(UserPermission::COMPANY, 'delete')
                        <x-button
                            id="company-delete-modal-trigger"
                            data-modal-target="company-delete-modal"
                            data-modal-toggle="company-delete-modal"
                            type="button"
                            variant="danger"
                        >Delete
                            Company</x-button>
                    @endpermitted
                </div>
            </form>
            <x-modal.confirm
                id="company-delete"
                type="delete"
                action="{{ route('companies.destroy', $company->id) }}"
                message="Are you sure you want to remove {{ $company->name }} from your list of companies?"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
