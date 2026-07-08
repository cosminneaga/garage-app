<x-layout::index title="User Permissions">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card
            description="Visualise & Edit user permissions"
        >
            <x-table.permissions
                :data="$permissions"
                edit
            />
        </x-card>
    </x-tabs>
</x-layout::index>
