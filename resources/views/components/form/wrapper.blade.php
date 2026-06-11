<div
    {{ $attributes->merge([
        'class' => 'border-2 border-white w-full px-4 py-6',
    ]) }}>
    <h1 class="text-3xl font-bold tracking-tight">
        {{ $title }}
    </h1>
    <p class="text-muted-foreground mt-1">
        {{ $description }}
    </p>
    <br>
    <div>
        {{ $slot }}
    </div>
</div>
