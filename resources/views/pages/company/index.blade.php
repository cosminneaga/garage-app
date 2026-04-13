<x-layout title="Company">
    <h1 class="text-2xl font-bold underline">COMPANIES</h1>
    <br><br>

    <x-table.companies
        :companies="$companies"
        edit_action
        delete_action
    />
</x-layout>
