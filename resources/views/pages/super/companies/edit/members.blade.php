<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $resource->name }}'s registered members"
        >
            <div class="mb-2 flex items-center gap-2">
                <x-form.search-box.table
                    id="company-members-search"
                    action="{{ route('super.companies.edit', $resource) }}"
                />
                    {{-- momemntarily on hold --}}
                    {{-- <x-modal.user.relation.attach
                        id="user-attach"
                        :resource="$resource"
                        :countries="$countries"
                        :existing_users="$non_members"
                        :title="Auth::user()->isAdministrator()
                            ? 'Add an existing manager'
                            : 'Add an existing user'"
                    /> --}}
                    {{-- <x-modal.user.relation.create
                        id="user-create"
                        :resource="$resource"
                        :countries="$countries"
                        :title="Auth::user()->isAdministrator()
                            ? 'Create a new manager'
                            : 'Create a new user'"
                    /> --}}
            </div>

            <x-table.related.users
                :data="$members"
                :resource="$resource"
                edit
                delete
                chat
            />
        </x-card>
    </x-tabs>
</x-layout::index>
