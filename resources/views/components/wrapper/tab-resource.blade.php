@php
$queryTab = request()->query('tab');
@endphp

@props([
    'title' => 'Resource title',
    'subtitle' => '',
    'name' => 'tab_selector',
    'tabs' => [],
    'url' => '/'.request()->path(),
])

<div>

    <!-- HEADER -->
    <div class="">
        <h1 class="text-2xl font-bold underline">
            {{ strtoupper($title) }}
        </h1>

        <p class="text-muted-foreground mt-1">
            {{ $subtitle }}
        </p>
    </div>
    <br><br>
    <!-- HEADER -->

    <!-- BODY -->
    <x-bladewind.tab :name="$name">

        <x-slot:headings>
            @foreach ($tabs as $tab)
                <x-bladewind.tab.heading
                    :name="$tab['value']"
                    :label="$tab['label']"
                    :active="$queryTab === $tab['value']"
                    url="{{ $url }}?tab={{ $tab['slug']}}"
                />
            @endforeach
        </x-slot:headings>

        <x-bladewind.tab.body>
            {{ $slot }}
        </x-bladewind.tab.body>

    </x-bladewind.tab>
    <!-- BODY -->

</div>
