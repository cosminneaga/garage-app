<x-layout::index>
    <x-tabs :tabs="CompanyTabs::tabs()">
        <x-card
            description="Visualise & Edit {{ $resource->name }}'s registered members"
        >
            <div class="mb-2 flex items-center gap-2">
                <x-form.search-box.table
                    id="company-members-search"
                    action="{{ route('companies.edit', $resource) }}"
                />

                @permitted(UserPermission::USER, 'update')
                    <x-modal.user.relation.attach
                        id="user_attach"
                        :resource="$resource"
                        :countries="$countries"
                        :existing_users="$non_members"
                        trigger
                    />
                @endpermitted
                @permitted(UserPermission::USER, 'update')
                    <x-modal.user.relation.create
                        id="user_create"
                        action="{{ route('users.' . $resource->getTable() . '.store', $resource) }}"
                        :countries="$countries"
                        trigger
                    />
                @endpermitted
            </div>

            <x-table.related.users
                :data="$members"
                :resource="$resource"
                :edit="Permission::can(UserPermission::USER, 'show')"
                :delete="Permission::can(UserPermission::USER, 'delete')"
                chat
            />
        </x-card>
    </x-tabs>
</x-layout::index>
