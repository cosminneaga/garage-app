<x-layout::index title="{{ $invoice->number }}">
    <x-card>
        @json($invoice)
    </x-card>
</x-layout::index>
