@php
    use Illuminate\Pagination\LengthAwarePaginator;
@endphp

@props(['data'])

<div class="bg-neutral-primary-soft shadow-xs rounded-base border-default relative overflow-x-auto border">
    @isset($header)
        <div class="flex items-center p-4">
            {{ $header }}
        </div>
    @endisset

    <table {{ $attributes->merge(['class' => 'w-full text-sm text-left rtl:text-right text-body']) }}>
        <thead class="text-body bg-neutral-secondary-medium border-default-medium border-b text-sm">
            <tr>
                {{ $thead }}
            </tr>
        </thead>

        <tbody>
            {{ $tbody }}
        </tbody>
    </table>
    @if ($data instanceof LengthAwarePaginator)
        @php
            $pageUrls = $data->getUrlRange(1, $data->lastPage());
        @endphp
        <nav
            class="flex-column flex flex-wrap items-center justify-between p-4 md:flex-row"
            aria-label="Table navigation"
        >
            <div>
                <span class="text-body mb-4 block w-full text-sm font-normal md:mb-0 md:inline md:w-auto">
                    Page
                    <span class="text-heading font-semibold">{{ $data->currentPage() }}</span>
                    of
                    <span class="text-heading font-semibold">{{ $data->lastPage() }}</span>
                </span>
                <br>
                <span class="text-body mb-4 block w-full text-sm font-normal md:mb-0 md:inline md:w-auto">
                    Showing
                    <span class="text-heading font-semibold">{{ $data->count() }}</span>
                    items out of
                    <span class="text-heading font-semibold">{{ $data->total() }}</span>
                </span>
            </div>
            <ul class="flex -space-x-px text-sm">
                <li>
                    <a
                        class="text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading rounded-s-base box-border flex h-9 items-center justify-center border px-3 text-sm font-medium focus:outline-none"
                        href="{{ $data->previousPageUrl() }}"
                    >Previous</a>
                </li>

                <div
                    class="flex"
                    id="table-paginator-numbers"
                ></div>

                <li>
                    <a
                        class="text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading rounded-e-base box-border flex h-9 items-center justify-center border px-3 text-sm font-medium focus:outline-none"
                        href="{{ $data->nextPageUrl() }}"
                    >Next</a>
                </li>
            </ul>
        </nav>

        <script type="module">
            const currentPage = @json($data->currentPage());
            const total = @json($data->total());
            const pageUrls = @json($data->getUrlRange(1, $data->lastPage()));

            const pagination = new Pagination(currentPage, pageUrls);
            pagination.construct(document.getElementById('table-paginator-numbers'));
        </script>
    @endif
</div>

<!--

<script>
    const setLimit = (number) => {
        const url = new URL(window.location);
        url.searchParams.set('limit', number);
        window.location.href = url;
    };
</script>
-->
