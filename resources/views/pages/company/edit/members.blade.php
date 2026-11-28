<x-layout::index>
    <x-tabs :tabs="CompanyTabs::tabs()">
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
                        id="user_attach"
                        :resource="$company"
                        :countries="$countries"
                        :existing_users="$non_members"
                        trigger
                    />
                @endpermitted
                @permitted(UserPermission::USER, 'update')
                    <x-modal.user.relation.create
                        id="user_create"
                        action="{{ route('users.' . $company->getTable() . '.store', $company) }}"
                        :countries="$countries"
                        trigger
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
