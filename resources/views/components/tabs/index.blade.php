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
                    class="{{ $queryTab === $tab->slug ? $activeClass : '' }} rounded-t-base active group inline-flex items-center justify-center border-b p-4"
                    href="{{ $url }}?tab={{ $tab->slug }}"
                    aria-current="page"
                    data-test="{{ $tab->slug }}"
                >
                    {{ $tab->label }}
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
            $class .= $queryTab === $tabs[$index]->slug ? 'block' : 'hidden';

            $div->setAttribute('id', 'tab-' . $index);
            $div->setAttribute('class', $class);
            $div->setAttribute('role', 'tabpanel');
            $div->setAttribute('aria-labelledby', $index . '-tab');
        }

        echo $dom->saveHTML();
    @endphp
</div>
