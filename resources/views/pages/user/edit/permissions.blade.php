<x-layout::index title="Aplication Permissions">
    <x-tabs :tabs="UserTabs::ui()">
        <x-card description="Application Permissions">
            <x-table.permissions
                :data="$permissions"
                :remove="Permission::can(UserPermission::PERMISSION, 'update')"
                :user="$user"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
