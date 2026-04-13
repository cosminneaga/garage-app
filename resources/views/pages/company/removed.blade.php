<x-layout title="Removed Companies">
    <h1 class="text-2xl font-bold underline">REMOVED COMPANIES</h1>
    <br><br>

    <x-table.companies
        :companies="$companies"
        restore_action
    />
</x-layout>
