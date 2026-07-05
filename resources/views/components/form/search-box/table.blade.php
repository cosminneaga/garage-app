@props([
    'action' => route('users.index'),
    'id' => 'search-form-box',
    'method' => 'GET',
])

<form
    class="flex items-center gap-2"
    method="{{ $method }}"
    action="{{ $action }}"
>
    @foreach (request()->except('search') as $key => $value)
        <x-form.field
            name="{{ $key }}"
            type="text"
            value="{{ $value }}"
            hidden
        />
    @endforeach

    <x-form.field
        name="search"
        type="search"
        value="{{ request('search') }}"
    />
</form>
