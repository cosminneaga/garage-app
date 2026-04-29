<x-layout title="Suppliers">

    <h1 class="text-2xl font-bold underline">SUPPLIERS</h1>
    <br><br>

    <x-table.suppliers
        :suppliers="$suppliers"
        edit_action
        delete_action
    />

</x-layout>
