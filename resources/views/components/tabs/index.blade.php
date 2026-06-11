@php
    $queryTab = request()->query('tab') ?? 'details';
    $activeClass = 'text-fg-brand border-b border-brand';
    $url = '/' . request()->path();
@endphp

@props(['tabs'])

<div class="border-default mb-4 border-b">
    <ul
        class="-mb-px flex flex-wrap text-center text-sm font-medium"
        id="styled-tab"
        role="tablist"
        active
    >
        @foreach ($tabs as $index => $tab)
            <li class="me-2">
                <a
                    class="{{ $queryTab === $tab['slug'] ? $activeClass : '' }} rounded-t-base active group inline-flex items-center justify-center border-b p-4"
                    href="{{ $url }}?tab={{ $tab['slug'] }}"
                    aria-current="page"
                    data-test="{{ $tab['slug'] }}"
                >
                    {{-- <svg class="w-4 h-4 me-2 text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z"/></svg> --}}
                    {{ $tab['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<div id="tab-content">
    @php
        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($slot->toHTML());
        libxml_clear_errors();
        $divs = $dom->getElementsByTagName('tab');

        foreach ($divs as $index => $div) {
            $class = 'rounded-base bg-neutral-secondary-soft p-4 ';
            $class .= $queryTab === $tabs[$index]['slug'] ? 'block' : 'hidden';

            $div->setAttribute('id', 'tab-' . $index);
            $div->setAttribute('class', $class);
            $div->setAttribute('role', 'tabpanel');
            $div->setAttribute('aria-labelledby', $index . '-tab');
        }

        echo $dom->saveHTML();
    @endphp
</div>
