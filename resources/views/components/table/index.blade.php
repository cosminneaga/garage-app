
@php
    use Illuminate\Pagination\LengthAwarePaginator;
@endphp

@props([
    'data' => [],
    'limit' => 10,
])

<x-bladewind.card class="text-black overflow-auto">
    <x-bladewind.table {{ $attributes }}>
        <x-slot:header>
            {{ $header }}
        </x-slot:header>
        {{ $slot }}

        @if ($data instanceof LengthAwarePaginator)
            <!-- PAGINATION -->
            <div class="mt-5 flex flex-row justify-between">
                <div class="flex gap-4">
                    {{ $data->appends(['limit' => request('limit')])->links() }}

                    <x-bladewind.select
                        onselect="setLimit"
                        data="manual"
                        size="small"
                        selected_value="{{ request('limit') }}"
                        required
                    >
                        <x-bladewind.select.item
                            value="1"
                            label="1"
                        />
                        <x-bladewind.select.item
                            value="5"
                            label="5"
                        />
                        <x-bladewind.select.item
                            value="10"
                            label="10"
                        />
                        <x-bladewind.select.item
                            value="15"
                            label="15"
                        />
                        <x-bladewind.select.item
                            value="20"
                            label="20"
                        />
                        <x-bladewind.select.item
                            value="30"
                            label="30"
                        />

                    </x-bladewind.select>
                </div>
                <div class="text-sm">
                    <p>Showing {{ $data->count() }} of {{ $data->total() }}
                    </p>
                    <p>Page {{ $data->currentPage() }} of
                        {{ $data->lastPage() }}
                    </p>
                </div>
            </div>
        @endif
    </x-bladewind.table>
</x-bladewind.card>

<script>
    const setLimit = (number) => {
        const url = new URL(window.location);
        url.searchParams.set('limit', number);
        window.location.href = url;
    };
</script>
