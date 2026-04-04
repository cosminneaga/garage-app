<div
    {{ $attributes->merge([
        'class' => 'min-h-[calc(100dvh-4rem)] w-full px-4 py-6',
    ]) }}>
    <h1 class="text-3xl font-bold tracking-tight">
        {{ $title }}
    </h1>
    <p class="text-muted-foreground mt-1">
        {{ $description }}
    </p>
    <div>
        {{ $slot }}
    </div>
</div>
