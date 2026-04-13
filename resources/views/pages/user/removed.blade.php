<x-layout title="Removed">
    <h1 class="text-2xl font-bold underline">REMOVED TEAM MEMBERS</h1>
    <br><br>

    <x-table.users
        :users="$users"
        restore_action
    />
</x-layout>
