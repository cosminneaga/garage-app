<x-layout::index>
    <x-tabs :tabs="CompanyTabs::ui()">
        <x-card description="Visualise & Edit {{ $company->name }}'s registered members">
            <div class="mb-2 flex items-center gap-2">
                <form
                    class="flex items-center gap-2"
                    method="GET"
                    action="{{ route('companies.edit', $company) }}"
                >
                    @foreach (request()->except('search') as $key => $value)
                        <x-form.field
                            name="{{ $key }}"
                            type="text"
                            value="{{ $value }}"
                            hidden
                        />
                    @endforeach

                    <x-form.field
                        name="search"
                        type="search"
                        value="{{ request('search') }}"
                    />
                </form>

                <x-modal.user.relation.attach
                    id="user-attach"
                    :resource="$company"
                    :countries="$countries"
                    :existing_users="$non_members"
                />
                <x-modal.user.relation.create
                    id="user-create"
                    :resource="$company"
                    :countries="$countries"
                />
            </div>

            <x-table.related.users
                :data="$members"
                :resource="$company"
                :edit="Permission::can(UserPermission::USER, 'update')"
                :delete="Permission::can(UserPermission::COMPANY, 'update')"
                chat
            />
        </x-card>
    </x-tabs>
</x-layout::index>
