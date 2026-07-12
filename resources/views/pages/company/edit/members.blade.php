<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card
            description="Visualise & Edit {{ $company->name }}'s registered members"
        >
            <div class="mb-2 flex items-center gap-2">
                <x-form.search-box.table
                    id="company-members-search"
                    action="{{ route('companies.edit', $company) }}"
                />

                @permitted(UserPermission::USER, 'update')
                    <x-modal.user.relation.attach
                        id="user-attach"
                        :resource="$company"
                        :countries="$countries"
                        :existing_users="$non_members"
                        :title="Auth::user()->isAdministrator()
                            ? 'Add an existing manager'
                            : 'Add an existing user'"
                    />
                @endpermitted
                @permitted(UserPermission::USER, 'update')
                    <x-modal.user.relation.create
                        id="user-create"
                        :resource="$company"
                        :countries="$countries"
                        :title="Auth::user()->isAdministrator()
                            ? 'Create a new manager'
                            : 'Create a new user'"
                    />
                @endpermitted
            </div>

            <x-table.related.users
                :data="$members"
                :resource="$company"
                :edit="Permission::can(UserPermission::USER, 'show')"
                :delete="Permission::can(UserPermission::USER, 'delete')"
                chat
            />
        </x-card>
    </x-tabs>
</x-layout::index>
