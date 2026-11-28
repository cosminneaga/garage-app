<x-layout::index title="User Permissions">
    <x-tabs :tabs="UserTabs::tabs()">
        <x-card description="Visualise & Edit user permissions">
            <x-table.permissions
                :data="$permissions"
                :user="$user"
                edit
            />
        </x-card>
    </x-tabs>
</x-layout::index>
