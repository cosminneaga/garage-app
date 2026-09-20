@props([
    'title' => 'Modal title',
    'description' => null,
])

<div
    {{ $attributes->merge([
        'class' => 'border-2 border-white w-full px-4 py-6 z-99',
    ]) }}>
    <h1 class="text-3xl font-bold tracking-tight">{{ $title }}</h1>
    @if ($description)
        <p class="text-muted-foreground mt-1">{{ $description }}</p>
    @endif
    <br />
    <div>{{ $slot }}</div>
</div>
