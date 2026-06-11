<div
    {{ $attributes->merge([
        'class' => 'border-2 border-white w-full px-4 py-6 bg-neutral-primary-soft rounded-base shadow-xs text-gray-600"',
    ]) }}>
    @isset($title)
        <h1 class="text-3xl font-bold tracking-tight">
            {{ $title }}
        </h1>
    @endisset
    @isset($description)
        <p class="text-muted-foreground mt-1">
            {{ $description }}
        </p>
    @endisset
    <br>
    <div>
        {{ $slot }}
    </div>
</div>
