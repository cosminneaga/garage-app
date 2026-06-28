<x-layout::index title="Removed Companies">
    <h1 class="text-2xl font-bold underline">REMOVED COMPANIES</h1>
    <br /><br />

    <x-table.companies
        :data="$companies"
        :restore="Permission::can(UserPermission::COMPANY, 'restore')"
        searchRoute="{{ route('companies.removed') }}"
    />
</x-layout::index>
