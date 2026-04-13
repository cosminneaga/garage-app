<x-layout title="Team">
    <h1 class="text-2xl font-bold underline">TEAM</h1>
    <br><br>

    <x-table.users
        :users="$users"
        message_action
        edit_action
        delete_action
    />
</x-layout>


